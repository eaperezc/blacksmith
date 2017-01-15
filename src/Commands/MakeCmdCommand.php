<?php

namespace Blacksmith\Commands;

use Blacksmith\Command;
use Blacksmith\Arguments\MakeCmdArgument;
use Blacksmith\Console;
use Exception;

/**
 * The "Make Command" Command.
 *
 * This command is responsible for creating new commands that will be placed in
 * the commands directory in the target project's main directory. If provided 
 * subdirectories to create the command in, the CmdCommand class will place the
 * new command in those subdirectories.
 */

class MakeCmdCommand extends Command {

    // Set the signature for the command
    const signature       = 'make:cmd';

    // Set the description of the command
    const description     = 'Creates a new command';

    /**
     * The full path for the new command.
     * @var string
     */
    protected $command_dir_path;

    /**
     * The argument for this command.
     * @var Blacksmith\Arguments\Make\CmdArgument
     */
    protected $arg;

    /**
     * Create a new command.
     *
     * Gets the provided arguments and creates subdirectories if they do not already exist
     * for the provided command. The last element in the chain of subdirectories is treated
     * as the name of the callabale command, in which we create a template command file for.
     *
     * This method contains the order and registered methods regarding what to do when 
     * creating a new command for the first time.
     *
     * For example:
     *
     *      php blacksmith make:cmd this/is/my/command
     *
     * results in the following path being created:
     *
     *      my-project/commands/this/is/my/Command.php
     */
    public function run()
    {
        $args = $this->getArguments();

        // Validate argument was passed
        if (empty($args)) {
            throw new Exception(self::signature . ' requires an argument.');
        }

        $this->arg = new MakeCmdArgument($args[0]);

        $this->createSubDirectories();
        $this->createCommandFile();
    }

    /**
     * Create the subdirectories for the new command.
     */
    protected function createSubDirectories()
    {
        // Form the full path with sub dirs for the new command
        // e.g. "my-project/commands/my/new/Cmd.php"
        $this->command_dir_path = $this->console->getConfig()->getBlacksmithCommandsPath() . DIRECTORY_SEPARATOR . $this->arg->getSubDirPath();

        if (!file_exists($this->command_dir_path)) {
            mkdir($this->command_dir_path, 0755, true);
        }
    }

    /**
     * Create the .php file for the new command.
     *
     * Checks the argument to see if it has a php extension and appends it if it does not.
     * Also capitalizes the first letter of the command name file.
     *
     * If the file already exists, an alert will be output to the console and the execution
     * will be terminated. If it does not, the script will be generated and written to the 
     * file of the new command.
     */
    protected function createCommandFile()
    {
        $command_file_full_path = $this->command_dir_path . DIRECTORY_SEPARATOR . $this->arg->getCommandFileName();

        // Check if the command already exists
        if (file_exists($command_file_full_path)) {
            throw new Exception('Command already exists.');
        }

        // Create the file for the new command
        $command_file = fopen($command_file_full_path, 'w');

        // TODO: Create Script Generator to generate the PHP scripts for the new command.

        fclose($command_file);

        $this->console->getOutput()->println('File created at: ' . $command_file_full_path);
        $this->console->getOutput()->success('Command ' . $this->arg->getSignature() . ' created successfully.');
    }
}
