<?php

namespace Blacksmith\Commands;

use Blacksmith\Command;

/**
 * Blacksmith Bootstrap Command
 *
 * With this command we going to initialize the commands folder
 * and copy the blacksmith script to the root path so it is accessible
 * without having to type /vendor/bin. Also we could init any configuration
 * files or anything else we could need.
 */

class BootstrapCommand extends Command {

    // Set the signature for the command
    const signature       = 'bootstrap';

    // Set the description of the command
    const description     = 'Initializes the blacksmith elements in the project';


    // The name of the script
    private $script_name = null;

    /**
     * Main method that will run the
     * command operation.
     */
    public function run()
    {

        // if we are on the vendor folder it means we are
        // been called from inside the composer libraries
        if (strpos(BLACKSMITH_ROOT, 'vendor') !== false) {
            return;
        }

        // check arguments
        $this->checkArguments();

        // initialize stuff
        $this->copyBlacksmithToRoot();
        $this->initializeCommandsFolder();

        // Funny success message
        $this->console->output->println('Blacksmith is ready to work in metal! Hammer down!', 'purple');
    }

    /**
     * This function will get the parameters that the user entered
     * when calling this command.
     */
    public function checkArguments()
    {
        // This argument checks if the user wants a different name for the script
        if ($index = in_array('-n', $this->getArguments())) {

            // Verify that we have a value for the argument
            if (!isset($this->getArguments()[$index + 1])) {
                $this->console->output->alert('The --name argument needs to be followed by the value');
                return;
            }

            $this->script_name = $this->getArguments()[$index + 1];
        }
    }

    /**
     * Here we will copy the blacksmith command tool
     * to the root of the project. Please
     */
    public function copyBlacksmithToRoot()
    {
        // we create a root copy of the script
        if (copy(BLACKSMITH_ROOT . '/vendor/bin/blacksmith', $this->script_name?:'blacksmith')) {
            // Add permission to excecute the file
            chmod($this->script_name?:'blacksmith', 0755);
        }
    }

    /**
     * This initializes the commands folder in the
     * project root folder.
     */
    public function initializeCommandsFolder()
    {
        if (!file_exists(BLACKSMITH_ROOT . '/commands')) {
            // create the blacksmith commands folder
            mkdir(BLACKSMITH_ROOT . '/commands');
        }

    }

}
