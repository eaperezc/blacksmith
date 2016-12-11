<?php

namespace Blacksmith\Examples;

use Blacksmith\Command;


class SayBye extends Command {

    // Set the signature for the command
    const signature     = 'say:bye';

    // Set the description of the command
    const description   = 'This will say goodbye.';

    /**
     * Main method that will run the
     * command operation.
     */
    public function run()
    {
        $this->console->output->println("Farewell cruel world T.T");
    }


}
