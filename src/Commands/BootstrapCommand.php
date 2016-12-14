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

        // initialize stuff
        $this->copyBlacksmithToRoot();
        $this->initializeCommandsFolder();
    }

    public function copyBlacksmithToRoot()
    {
        // we create a root copy of the script
        copy(BLACKSMITH_ROOT . '/vendor/bin/blacksmith', 'blacksmith');
    }

    public function initializeCommandsFolder()
    {
        // create the blacksmith commands folder
        mkdir(BLACKSMITH_ROOT , '/commands');
    }

}
