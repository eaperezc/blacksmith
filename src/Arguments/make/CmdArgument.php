<?php

namespace Blacksmith\Arguments\Make;

use Blacksmith\Argument;

/**
 * The "Make Command" Argument
 *
 * This class is responsible for easing the management of arguments
 * for the "make:cmd" command as an object to prevent app-wide
 * string manipulation.
 */
class CmdArgument extends Argument {

    /**
     * The array of subdirectories.
     * @var array
     */
    protected $sub_dirs;

    /**
     * The name of the command to create.
     * @var string
     */
    protected $command_name;

    /**
     * Constructor
     *
     * @param string $raw_arg
     *      The raw argument provided by the user.
     */
    public function __construct($raw_arg)
    {
        parent::__construct($raw_arg);
        $this->parseArgument();
    }

    /**
     * Parse the argument and determine the subdirectory path and command name.
     */
    protected function parseArgument()
    {
        $sub_dir_names = explode(DIRECTORY_SEPARATOR, $this->raw_arg);
        $command_name  = $sub_dir_names[count($sub_dir_names) - 1];

        // Remove the command name from the list of sub dirs
        unset($sub_dir_names[count($sub_dir_names) - 1]);

        $this->sub_dirs     = $sub_dir_names;
        $this->command_name = $command_name;
    }

    /**
     * Returns the name of the command that was parsed from the argument.
     *
     * @return string
     */
    public function getCommandName()
    {
        return $this->command_name;
    }

    /**
     * Returns the sub directory path as a string instead of as an array.
     *
     * @return string
     */
    public function getSubDirPath()
    {
        return implode(DIRECTORY_SEPARATOR, $this->sub_dirs);
    }

    /**
     * Returns the possible signature of the argument.
     *
     * @return string
     */
    public function getSignature()
    {
        $command_name = $this->command_name;

        // Remove php extension if it exists
        if ($this->hasPhpExtension()) {
            $command_name = str_replace('.php', '', $this->command_name);
        }

        // Convert to underscore_notation
        $command_name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $command_name));

        return str_replace(DIRECTORY_SEPARATOR, ":", $this->getSubDirPath()) . ":" . $command_name;
    }

    /**
     * Returns the name of the command as it would appear as a .php file.
     */
    public function getCommandFileName()
    {
        $command_name = $this->command_name;

        if (!$this->hasPhpExtension()) {
            $command_name = $command_name . '.php';
        }

        // Captialize the first letter and only the first letter
        $first_letter = mb_substr($command_name, 0, 1, 'utf-8');
        $first_letter = strtoupper($first_letter);

        $command_name[0] = $first_letter;

        return $command_name;
    }

    /**
     * Checks if the the user provided a .php extension in the command name.
     *
     * @return boolean
     */
    public function hasPhpExtension()
    {
        // Check if the command already has the .php extension
        $file_extension = strtolower(pathinfo($this->command_name, PATHINFO_EXTENSION));

        return $file_extension === 'php';
    }
}