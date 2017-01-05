<?php

namespace Blacksmith\Commands;

use Blacksmith\Command;
use Exception;

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
        // check arguments
        $this->checkArguments();

        // initialize stuff
        $this->copyBlacksmithToRoot();
        $this->initializeCommandsFolder();
        $this->initializeBlacksmithXmlFile();

        // Funny success message
        $this->console->getOutput()->println('Blacksmith is ready to work the metal! Hammer down!', 'purple');
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
                throw new Exception('The --name argument needs to be followed by the value');
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
        $blacksmith_bin_path = [
            $this->console->getConfig()->getBlacksmithRootPath(),
            $this->console->getConfig()->getBlacksmithBinPath()
        ];

        $blacksmith_bin_path = implode(DIRECTORY_SEPARATOR, $blacksmith_bin_path);

        // if we are on the vendor folder it means we are
        // been called from inside the composer libraries
        if (!file_exists($blacksmith_bin_path)) {
            return;
        }

        // we create a root copy of the script
        if (copy($blacksmith_bin_path, $this->script_name?:'blacksmith')) {
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
        // The commands folder path
        $cmds_folder_path = $this->console->getConfig()->getBlacksmithCommandsPath();

        if (!file_exists($cmds_folder_path)) {
            // create the blacksmith commands folder
            mkdir($cmds_folder_path);
        }
    }

    /**
     * Creates the blacksmith.xml file which is used to hold the list of available commands
     * that points to their respective class locations.
     */
    public function initializeBlacksmithXmlFile()
    {
        $blacksmith_xml_path = $this->console->getConfig()->getBlacksmithXmlPath();

        // Create the blacksmith.xml file only if it doesn't exist yet.
        if (!file_exists($blacksmith_xml_path)) {

            // Create the blacksmith.xml file
            touch($blacksmith_xml_path);

            $blacksmith_xml_file = fopen($blacksmith_xml_path, 'w');

            // Copy the default blacksmith.xml settings
            $content = file_get_contents(
                $this->console->getConfig()->getTemplates()['blacksmith_xml_path']
            );

            // TODO: Write the configurations to the file.
            fwrite($blacksmith_xml_file, $content);

            fclose($blacksmith_xml_file);
        }
    }
}
