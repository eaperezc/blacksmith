<?php

namespace Blacksmith\Commands;

use Blacksmith\Command;
use Blacksmith\IO\MenuBuilder;

/**
 * Blacksmith Help Command
 *
 * With this command we are taking care of generating the
 * help message that we show to the user. This will add automatically
 * each new command that is defined in the config.
 */

class HelpCommand extends Command {

    // Set the signature for the command
    const signature       = 'help';

    // Set the description of the command
    const description     = 'Show the usage and command list';


    /**
     * Main method that will run the
     * command operation.
     */
    public function run()
    {
        $this->showHelp();
    }

    /**
     * This will display the information to the user
     * generating the list of available commands
     */
    public function showHelp()
    {
        $this->printTitle();
        $this->showCommandsList();
    }

    /**
     * Prints the ASCII title that is
     * showed in the console + some more extra information
     */
    public function printTitle()
    {

        $this->console->output->printlns([
            '',
            '------------------------------------------------------------------------',
            '      ______  _               _                     _  _    _     ',
            '      | ___ \| |             | |                   (_)| |  | |    ',
            '      | |_/ /| |  __ _   ___ | | __ ___  _ __ ___   _ | |_ | |__  ',
            "      | ___ \| | / _` | / __|| |/ // __|| '_ ` _ \ | || __|| '_ \ ",
            '      | |_/ /| || (_| || (__ |   < \__ \| | | | | || || |_ | | | |',
            '      \____/ |_| \__,_| \___||_|\_\|___/|_| |_| |_||_| \__||_| |_|',
            '------------------------------------------------------------------------',
            '',
            'Welcome to the Blacksmith! Create your own cli scripts with php.',
            'Version: 0.0.1',
            ''
        ]);

        $this->console->output->println('Usage:', 'yellow');
        $this->console->output->println('  php blacksmith [command] [arguments]');
        $this->console->output->println();

        $this->console->output->println('Available Commands:', 'yellow');
    }

    /**
     * Show the Command list
     */
    public function showCommandsList()
    {
        // Loop through the commands to show its info
        foreach ($this->console->commands as $command) {
            $this->console->output->println('  ' . $command::signature, 'green', "");
            $this->console->output->println(str_pad('  ', 25 - strlen($command::signature),' ') . $command::description);
        }

        // Some extra spaces
        $this->console->output->println("\n\r");
    }

}
