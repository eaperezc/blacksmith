<?php

namespace Blacksmith\Examples;

use Blacksmith\Command;


class SayHello extends Command {

    // Set the signature for the command
    const signature     = 'say:hello';

    // Set the description of the command
    const description   = 'To say Hi to all the world.';

    /**
     * Main method that will run the
     * command operation.
     */
    public function run()
    {
        // get command arguments
        $arguments = $this->getArguments();

        // If we have an argument we will say hello to it
        if (sizeof($arguments) > 0) {
            $this->console->output->println("Hello " . $arguments[0]);
            return;
        }

        $this->console->output->println("Hello World");
    }


}
