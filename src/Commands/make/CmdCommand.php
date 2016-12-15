<?php

namespace Blacksmith\Commands\Make;

use Blacksmith\Command;
use Exception;

/**
 * The "Make Command" Command.
 *
 * This command is responsible for creating new commands that will be placed in
 * the commands directory in the target project's main directory. If provided 
 * subdirectories to create the command in, the CmdCommand class will place the
 * new command in those subdirectories.
 */

class CmdCommand extends Command {

    // Set the signature for the command
    const signature       = 'make:cmd';

    // Set the description of the command
    const description     = 'Creates a new command';

    /**
     * The full path for the new command.
     * @var string
     */
    protected $command_dir_path = '';

    /**
     * The argument to create the filepath and command for.
     * @var string
     */
    protected $filepath;

    /**
     * Main method that will run the
     * command operation.
     */
    public function run()
    {
        // Validate argument was passed
        if (empty($this->getArguments())) {
            $this->console->output->alert('make:cmd requires an argument.');
            return;
        }

        $this->createCommand();
    }

    /**
     * Create a new command.
     *
     * Gets the provided arguments and creates subdirectories if they do not already exist
     * for the provided command. The last element in the chain of subdirectories is treated
     * as the name of the callabale command, in which we create a template command file for.
     *
     * For example:
     *
     *      php blacksmith make:cmd this/is/my/command
     *
     * results in the following path being created:
     *
     *      my-project/commands/this/is/my/Command.php
     */
    protected function createCommand()
    {
        $this->filepath = $this->getArguments()[0];

        $sub_dir_names = explode(DIRECTORY_SEPARATOR, $this->filepath);
        $command_name  = $sub_dir_names[count($sub_dir_names) - 1];

        // Remove the command name from the list of sub dirs
        unset($sub_dir_names[count($sub_dir_names) - 1]);

        $this->createSubDirectories($sub_dir_names);
        $this->createCommandFile($command_name);
    }

    /**
     * Create the subdirectories for the new command.
     *
     * @param array $sub_dirs
     *      The array of subdirectory names to create for the new command.
     */
    protected function createSubDirectories(array $sub_dirs)
    {
        // Get the path to the /commands folder
        $blacksmith_cmd_dir = BLACKSMITH_ROOT . BLACKSMITH_COMMANDS_DIR;

        // Form the full path with sub dirs for the new command
        // e.g. "my-project/commands/my/new/Cmd.php"
        $this->command_dir_path = $blacksmith_cmd_dir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $sub_dirs);

        if (!file_exists($this->command_dir_path)) {
            mkdir($this->command_dir_path, 0755, true);
        }
    }

    /**
     * Create the .php file for the new command.
     *
     * @param string $command_name
     *      The name of the new command to create the command file for.
     */
    protected function createCommandFile($command_name)
    {
        // Check if the command already has the .php extension
        $file_extension = strtolower(pathinfo($command_name, PATHINFO_EXTENSION));

        if ($file_extension !== 'php') {
            $command_name .= '.php';
        }

        $command_file_name      = ucfirst($command_name);
        $command_file_full_path = $this->command_dir_path . DIRECTORY_SEPARATOR . $command_file_name;

        try {

            // Check if the command already exists
            if (file_exists($command_file_full_path)) {
                throw new Exception('Command already exists.');
            }

            // Create the file for the new command
            $command_file = fopen($command_file_full_path, 'w');

            fclose($command_file);

        } catch (Exception $e) {

            $this->console->output->alert($e->getMessage());
            return;
        }

        $command_signature = str_replace("/", ":", $this->filepath);

        $this->console->output->println('File created at: ' . $command_file_full_path);
        $this->console->output->success('Command ' . $command_signature . ' created successfully.');
    }
}
