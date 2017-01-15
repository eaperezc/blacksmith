<?php

namespace Blacksmith;

use Blacksmith\Console;
use org\bovigo\vfs\vfsStream;


class ConsoleTest extends \PHPUnit_Framework_TestCase {


    private $console = null;


    protected function setUp()
    {
        $this->root = vfsStream::setup('root');
        $this->root_path = vfsStream::url('root');

        $this->createBlacksmithXmlFile();

        $dependencies = [
            'blacksmith_root_path'     => $this->root_path,
            'blacksmith_commands_path' => $this->root_path . '/commands',
            'blacksmith_bin_path'      => 'vendor/bin/blacksmith',
            'blacksmith_xml_path'      => $this->root_path . '/blacksmith.xml',
            'templates' => [
                'blacksmith_xml_path' => $this->root_path . '/templates/config/blacksmith.xml'
            ]
        ];

        $config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getBlacksmithRootPath')
            ->will($this->returnValue($dependencies['blacksmith_root_path']));

        $config->method('getBlacksmithBinPath')
            ->will($this->returnValue($dependencies['blacksmith_bin_path']));

        $config->method('getBlacksmithCommandsPath')
            ->will($this->returnValue($dependencies['blacksmith_commands_path']));

        $config->method('getBlacksmithXmlPath')
            ->will($this->returnValue($dependencies['blacksmith_xml_path']));

        $config->method('getTemplates')
            ->will($this->returnValue($dependencies['templates']));

        $raw_arguments = [
            'blacksmith',
            'make:command'
        ];

        $this->console = new Console($config, $raw_arguments);
    }

    /**
     * Creates a mock xml file in place of blacksmith.xml, which is used to
     * hold the list of available commands.
     */
    public function createBlacksmithXmlFile()
    {
        $commands_xml = '<?xml version="1.0"?>' .
            '<commands>' .
                '<command class="Blacksmith\TestCommandMock"/>' .
                '<command class="Blacksmith\TestCommand2Mock"/>' .
            '</commands>';

        $commands_xml_file = $this->root_path . '/blacksmith.xml';

        touch($commands_xml_file);
        file_put_contents($commands_xml_file, $commands_xml);
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
