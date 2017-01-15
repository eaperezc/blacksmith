<?php

namespace Blacksmith;

use Blacksmith\Commands\BootstrapCommand;
use Blacksmith\Console;
use Blacksmith\IO\Output;
use org\bovigo\vfs\vfsStream;
use Exception;


class BootstrapCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * The virtual root path.
     * @var org\bovigo\vfs\vfsStream
     */
    protected $root;

    /**
     * The array of Blacksmith dependencies.
     * @var array
     */
    protected $dependencies;

    /**
     * The mocked config object.
     * @var Blacksmith\Config (Mocked)
     */
    protected $config;

    public function setUp()
    {
        $this->root_dir_name = 'root';
        $this->root          = vfsStream::setup($this->root_dir_name);
        $this->root_path     = vfsStream::url($this->root_dir_name);

        $this->dependencies = [
            'blacksmith_root_path'     => $this->root_path,
            'blacksmith_commands_path' => $this->root_path . DIRECTORY_SEPARATOR . 'commands',
            'blacksmith_bin_path'      => 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'blacksmith',
            'blacksmith_xml_path'      => $this->root_path . DIRECTORY_SEPARATOR . 'blacksmith.xml',
            'templates' => [
                'blacksmith_xml_path' => $this->root_path . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'blacksmith.xml'
            ]
        ];

        $this->createBlacksmithXmlTemplate();

        $config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getBlacksmithRootPath')
            ->will($this->returnValue($this->dependencies['blacksmith_root_path']));

        $config->method('getBlacksmithBinPath')
            ->will($this->returnValue($this->dependencies['blacksmith_bin_path']));

        $config->method('getBlacksmithCommandsPath')
            ->will($this->returnValue($this->dependencies['blacksmith_commands_path']));

        $config->method('getBlacksmithXmlPath')
            ->will($this->returnValue($this->dependencies['blacksmith_xml_path']));

        $config->method('getTemplates')
            ->will($this->returnValue($this->dependencies['templates']));

        $this->config = $config;
    }

    public function tearDown()
    {
        $this->root         = null;
        $this->root_path    = null;
        $this->dependencies = null;
    }

    /**
     * Sets up a test template blacksmith.xml file.
     */
    public function createBlacksmithXmlTemplate()
    {
        $xml_template_dir  = vfsStream::url($this->root_dir_name . '/templates/config');
        $xml_template_file = $xml_template_dir . '/blacksmith.xml';

        mkdir($xml_template_dir, 0755, true);
        touch($xml_template_file);
        file_put_contents($xml_template_file, 'Test Content');
    }

    public function testRunningBootstrapCommandCreatesCommandsDirectory()
    {
        $raw_arguments = [
            'blacksmith',
            'bootstrap'
        ];

        $output = $this->getMockBuilder(Output::class)
            ->disableOriginalConstructor()
            ->getMock();

        $output->method('println')
            ->with($this->anything())
            ->will($this->returnValue('Line printed.'));

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getOutput')
            ->will($this->returnValue($output));

        $console->method('getRawArguments')
            ->will($this->returnValue($raw_arguments));

        $console->method('getConfig')
            ->will($this->returnValue($this->config));

        $command = new BootstrapCommand($console);
        $command->run();

        $expected_result = 'commands';

        $this->assertTrue($this->root->hasChild($expected_result));
    }

    public function testBootstrapCommandProperlyCreatesBlacksmithXmlFileWhenRun()
    {
        $raw_arguments = [
            'blacksmith',
            'bootstrap'
        ];

        $output = $this->getMockBuilder(Output::class)
            ->disableOriginalConstructor()
            ->getMock();

        $output->method('println')
            ->with($this->anything())
            ->will($this->returnValue('Line printed.'));

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue($raw_arguments));

        $console->method('getOutput')
            ->will($this->returnValue($output));

        $console->method('getConfig')
            ->will($this->returnValue($this->config));

        $command = new BootstrapCommand($console);
        $command->run();

        $expected_result = 'blacksmith.xml';

        $this->assertTrue($this->root->hasChild($expected_result));
    }

    /**
     * @expectedException Exception
     */
    public function testBootstrapCommandThrowsExceptionIfNameOptionIsProvidedWithNoArgument()
    {
        $raw_arguments = [
            'blacksmith',
            'bootstrap',
            '-n'
        ];

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue($raw_arguments));

        $command = new BootstrapCommand($console);
        $command->run();
    }

    public function testBootstrapCommandProperlyCopiesOverDefaultXmlCommandConfigurationSettingsFromTemplate()
    {
        $raw_arguments = [
            'blacksmith',
            'bootstrap'
        ];

        $output = $this->getMockBuilder(Output::class)
            ->disableOriginalConstructor()
            ->getMock();

        $output->method('println')
            ->with($this->anything())
            ->will($this->returnValue('Line printed.'));

        $console = $this->getMockBuilder(Console::class)
            ->disableOriginalConstructor()
            ->getMock();

        $console->method('getRawArguments')
            ->will($this->returnValue($raw_arguments));

        $console->method('getOutput')
            ->will($this->returnValue($output));

        $console->method('getConfig')
            ->will($this->returnValue($this->config));

        $command = new BootstrapCommand($console);
        $command->run();

        $template_content = file_get_contents($this->root_path . '/blacksmith.xml');

        $this->assertEquals('Test Content', $template_content);
    }
}