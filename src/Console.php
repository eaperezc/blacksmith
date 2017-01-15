<?php

namespace Blacksmith;

use Blacksmith\Config;
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
     * The Config 
     */
    public $config;

    /**
     * console output helper object
     * @see Blacksmith\IO\Output
     */
    public $output = null;

    /**
     * Constructor
     *
     * Sets the arguments and dependencies for the Blacksmith application.
     *
     * @param array $arguments
     *      The arguments provided by the end user.
     * @param Blacksmith\Config $config
     *      The dependencies required by the Blacksmith application.
     */
    function __construct(Config $config, $arguments = [])
    {
        $this->setConfig($config);
        $this->setRawArguments($arguments);
        $this->setOutput(new Output());
        $this->loadCommands();
    }

    /**
     * Loads the registered commands based on the blacksmith.xml file.
     *
     * If the blacksmith.xml file is not found in the root project, Blacksmith
     * will pull the default blacksmith.xml configurations found in
     * templates/config/blacksmith.xml.
     */
    protected function loadCommands()
    {
        $blacksmith_xml_path = !file_exists($this->config->getBlacksmithXmlPath())
            ? $this->config->getTemplates()['blacksmith_xml_path']
            : $this->config->getBlacksmithXmlPath();

        $blacksmith_xml_file = simplexml_load_file($blacksmith_xml_path);

        foreach ($blacksmith_xml_file->children() as $command) {
            $this->commands[] = (string) $command['class'];
        }
    }

    /**
     * Sets the Raw array of arguments
     * passed to the command line
     */
    public function setRawArguments(array $args)
    {
        $this->command   = null;
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
        if (sizeof($this->arguments) <= 1) {
            return new HelpCommand($this);
        }

        $signature = $this->arguments[1];

        foreach ($this->commands as $cmd) {
            if ($cmd::signature === $signature) {
                return new $cmd($this);
            }
        }
    }

    /**
     * Getter for the command instance
     */
    public function getCommand()
    {
        if (!$this->command) {
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

    /**
     * Sets the dependency used for printing to the console.
     *
     * @param Output $output
     *      The "output" engine used to print messages to the console.
     */
    protected function setOutput(Output $output)
    {
        $this->output = $output;
    }

    /**
     * Gets the objects used to output to console.
     *
     * @return Output
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Sets the configuration settings on the console.
     *
     * @param Blacksmith\Config $config
     *      Contains the Blacksmith configuration details.
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Gets the configuration settings.
     *
     * @return Blacksmith\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
