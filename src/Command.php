<?php

namespace Blacksmith;

/**
 * This class is the one that all the commands
 * should inherit from. It has the base command
 * functionality.
 */

abstract class Command {

    // A reference to the Console object
    public $console;

    // This is the name of the command
    const signature = '';


    function __construct(Console $console)
    {
        $this->console = $console;
    }

    /**
     * This is the main method that will be executed
     * when the command is typed in the terminal.
     */
    public function run()
    {
        # Override this method in child classes
    }


    /**
     * This method will return the list of arguments
     * valid for the command
     */
    public function getArguments()
    {
        // get the raw arguments the console got
        $args = $this->console->getRawArguments();

        // remove the "blacksmith" argument
        // and remove the "command signature" argument
        if ($args[0] === 'blacksmith' || $args[0] === $this::signature)
            unset($args[0]);

        // remove the second parameter if it is the command signature
        if ($args[1] === $this::signature)
            unset($args[1]);

        return array_values($args);
    }



}
