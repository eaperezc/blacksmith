<?php

namespace Blacksmith;

/**
 * The Config Class.
 *
 * This class is responsible for maintaining and validating configuration settings
 * for the entire Blacksmith app.
 */
class Config {

    /**
     * The root path of the Blacksmith app.
     * @var string
     */
    private $blacksmith_root_path;

    /**
     * The path to the "commands" directory.
     * @var string
     */
    private $blacksmith_commands_path;

    /**
     * The path to the "blacksmith" binary executable.
     * @var string
     */
    private $blacksmith_bin_path;

    /**
     * The path the blacksmith.xml configuration file.
     * @var string
     */
    private $blacksmith_xml_path;

    /**
     * The path to the templates that are used for building scripts and
     * configuration files.
     * @var array
     */
    private $templates;

    /**
     * Constructor
     *
     * @param array $dependencies
     *      The array of Blacksmith dependencies.
     */
    public function __construct($dependencies = [])
    {
        $this->setBlacksmithRootPath($dependencies['blacksmith_root_path']);
        $this->setBlacksmithCommandsPath($dependencies['blacksmith_commands_path']);
        $this->setBlacksmithBinPath($dependencies['blacksmith_bin_path']);
        $this->setBlacksmithXmlPath($dependencies['blacksmith_xml_path']);
        $this->setTemplates($dependencies['templates']);
    }

    /**
     * Set the root directory path of the Blacksmith project.
     *
     * The path is an absolute path.
     *
     * @param string $blacksmith_root_path
     *      The absolute path to the location of the Blacksmith project.
     */
    protected function setBlacksmithRootPath($blacksmith_root_path)
    {
        $this->blacksmith_root_path = $blacksmith_root_path;
    }

    /**
     * Gets the root directory of the Blacksmith project.
     *
     * The path returned is an absolute path.
     *
     * @return string
     */
    public function getBlacksmithRootPath()
    {
        return $this->blacksmith_root_path;
    }

    /**
     * Set the location of the Blacksmith "commands" directory which is
     * where new commands are stored.
     *
     * @param string $blacksmith_commands_path
     *      The absolute path of where new commands should be created in.
     */
    protected function setBlacksmithCommandsPath($blacksmith_commands_path)
    {
        $this->blacksmith_commands_path = $blacksmith_commands_path;
    }

    /**
     * Gets the absolute path of the commands directory to the current project.
     *
     * The path returned is a absolute path.
     *
     * @return string
     */
    public function getBlacksmithCommandsPath()
    {
        return $this->blacksmith_commands_path;
    }

    /**
     * Sets the path to the binary executable of the Blacksmith project.
     *
     * @param string $blacksmith_bin_path
     *      The path of the binary executable.
     */
    protected function setBlacksmithBinPath($blacksmith_bin_path)
    {
        $this->blacksmith_bin_path = $blacksmith_bin_path;
    }

    /**
     * Gets the path to the binary executable of the Blacksmith Project.
     *
     * @return string
     */
    public function getBlacksmithBinPath()
    {
        return $this->blacksmith_bin_path;
    }

    /**
     * Sets the path to the blacksmith.xml command configuration file.
     *
     * @param string $blacksmith_xml_path
     *      The path to the blacksmith.xml file.
     */
    protected function setBlacksmithXmlPath($blacksmith_xml_path)
    {
        $this->blacksmith_xml_path = $blacksmith_xml_path;
    }

    /**
     * Gets the path to the blacksmith.xml file.
     *
     * @return string
     */
    public function getBlacksmithXmlPath()
    {
        return $this->blacksmith_xml_path;
    }

    /**
     * Sets the list of paths to locate the templates files used for configuraton and
     * new command generation.
     * 
     * @var array $templates
     *      The array of paths to the templates.
     */
    protected function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    /**
     * Gets the list of paths of the template file locations.
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }
}