<?php

namespace Blacksmith;

use Blacksmith\Console;


class ConsoleTest extends \PHPUnit_Framework_TestCase {


    private $console = null;


    protected function setUp()
    {
        $this->console = new Console;

        $this->console->setRawArguments([
            0 => 'blacksmith',
            1 => 'make:command'
        ]);

        $this->console->commands = [
            TestCommandMock::class,
            TestCommand2Mock::class
        ];
    }


    public function testCommandLookup()
    {
        $command = $this->console->getCommand();
        $this->assertEquals('make:command', $command::signature);


        $this->console->setRawArguments([
            0 => 'blacksmith',
            1 => 'make:command2'
        ]);

        $command = $this->console->getCommand();
        $this->assertEquals('make:command2', $command::signature);

        $this->console->setRawArguments([
            0 => 'blacksmith',
            1 => 'make:command3'
        ]);

        $command = $this->console->getCommand();
        $this->assertNull($command);
    }

}


class TestCommandMock extends \Blacksmith\Command {
    const signature = 'make:command';
}

class TestCommand2Mock extends \Blacksmith\Command {
    const signature = 'make:command2';
}
