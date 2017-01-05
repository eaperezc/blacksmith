<?php

namespace Blacksmith;

use Blacksmith\Commands\MakeCmdCommand;
use Blacksmith\Console;
use Blacksmith\IO\Output;
use org\bovigo\vfs\vfsStream;
use Exception;


class MakeCmdCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * Specifies the root directory for the virtual files system (vfs).
     * @var vfsStreamDirectory
     */
    protected $root;

    public function setUp()
    {
        $this->root_path         = 'root';
        $this->virtual_root_path = vfsStream::setup($this->root_path);
    }

    public function testRunningMakeCmdCommandCreatesFileCorrectlyInSpecifiedFilePath()
    {
        $arguments = [
            'blacksmith',
            'make:cmd',
            'some/file/path'
        ];

        $output = $this->getMockBuilder(Output::class)
            ->disableOriginalConstructor()
            ->getMock();

        $output->method('println')
            ->with($this->anything())
            ->will($this->returnValue('Line printed.'));

        $output->method('success')
            ->with($this->anything())
            ->will($this->returnValue('Success line printed.'));

        $config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getBlacksmithCommandsPath')
            ->will($this->returnValue(vfsStream::url($this->root_path . '/commands')));

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue($arguments));

        $console->method('getOutput')
            ->will($this->returnValue($output));

        $console->method('getConfig')
            ->will($this->returnValue($config));

        $command = new MakeCmdCommand($console);
        $command->run();

        $expected_result = 'commands/some/file/Path.php';

        $this->assertTrue($this->virtual_root_path->hasChild($expected_result));
    }

    /**
     * @expectedException Exception
     */
    public function testMakeCmdCommandDoesNotRunIfNoArgumentsArePassed()
    {
        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue([]));

        $command = new MakeCmdCommand($console);
        $command->run();
    }

    /**
     * @expectedException Exception
     */
    public function testMakeCmdCommandThrowsExceptionIfCommandProvidedAlreadyExists()
    {
        $existing_dir = vfsStream::url($this->root_path . '/commands/file/already');
        $existing_file = $existing_dir . '/Exists.php';

        // Make the file exist by creating it in the VFS
        mkdir($existing_dir, 0755, true);
        touch($existing_file);

        $arguments = [
            'blacksmith',
            'make:cmd',
            'file/already/exists'
        ];

        $config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getBlacksmithCommandsPath')
            ->will($this->returnValue(vfsStream::url($this->root_path . '/commands')));

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue($arguments));

        $console->method('getConfig')
            ->will($this->returnValue($config));

        $command = new MakeCmdCommand($console);
        $command->run();
    }
}
