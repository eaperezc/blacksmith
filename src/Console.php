<?php

namespace Blacksmith;

use Blacksmith\IO\Output;
use Blacksmith\Commands\HelpCommand;

/**
 * Blacksmith Console Class
 *
 * This is the main class in the library and is the one
 * that takes care of handling the setup and initialization
 * of everything the command needs to run.
 */

class Console {

    // This would be an array of all the classes
    // that are possible commands to run
    public $commands = [];


    // After the initCommand has been called this
    // is the instance of the Command class
    private $command = null;


    // This holds the commands arguments
    private $arguments = [];

    /**
     * console output helper object
     * @see Blacksmith\IO\Output
     */
    public $output = null;


    function __construct($arguments = [])
    {
        $this->setRawArguments($arguments);
        $this->output = new Output;
    }

    /**
     * Sets the Raw array of arguments
     * passed to the command line
     */
    public function setRawArguments(array $args)
    {
        $this->command = null;
        $this->arguments = $args;
    }

    /**
     * Gets the Raw array of arguments
     * passed to the command line
     */
    public function getRawArguments()
    {
        return $this->arguments;
    }

    /**
     * Initialize Command Object
     *
     * With this method we find the correct Command class
     * that we need to instantiate. The Help Command is default
     * if no argument for the command signature is passed.
     */
    public function initCommand()
    {
        if(sizeof($this->arguments) <= 1) {
            return new HelpCommand($this);
        }

        $signature = $this->arguments[1];

        foreach ($this->commands as $cmd) {
            if($cmd::signature === $signature) {
                return new $cmd($this);
            }
        }
    }

    /**
     * Getter for the command instance
     */
    public function getCommand()
    {
        if( !$this->command ){
            $this->command = $this->initCommand();
        }
        return $this->command;
    }

    /**
     * Console Handle
     *
     * This is the one that excecutes the run method on the
     * command instance, and validates that there is an actual
     * object to run.
     */
    public function handle()
    {

        if (is_null($this->getCommand())) {
            $this->output->println("Command was not found.", 'red');
            exit;
        }

        $this->command->run();

    }

}
