<?php

namespace Blacksmith;

use Blacksmith\Config;
use org\bovigo\vfs\vfsStream;
use Exception;


class ConfigTest extends \PHPUnit_Framework_TestCase {

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

    public function setUp()
    {
        $this->root = vfsStream::setup('root');
        $this->root_path = vfsStream::url('root');

        $this->dependencies = [
            'blacksmith_root_path'     => $this->root_path,
            'blacksmith_commands_path' => $this->root_path . DIRECTORY_SEPARATOR . 'commands',
            'blacksmith_bin_path'      => 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'blacksmith',
            'blacksmith_xml_path'      => $this->root_path . DIRECTORY_SEPARATOR . 'blacksmith.xml',
            'templates' => [
                'blacksmith_xml_path' => 'templates' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'blacksmith.xml'
            ]
        ];
    }

    public function testDependenciesProperlyGetSetToConfigWhenPassedThroughConstructor()
    {
        $config = new Config($this->dependencies);

        $this->assertEquals($this->dependencies['blacksmith_root_path'], $config->getBlacksmithRootPath());
        $this->assertEquals($this->dependencies['blacksmith_commands_path'], $config->getBlacksmithCommandsPath());
        $this->assertEquals($this->dependencies['blacksmith_bin_path'], $config->getBlacksmithBinPath());
        $this->assertEquals($this->dependencies['blacksmith_xml_path'], $config->getBlacksmithXmlPath());
        $this->assertEquals($this->dependencies['templates'], $config->getTemplates());
    }
}