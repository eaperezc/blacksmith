<?php

namespace Blacksmith;

use Blacksmith\Arguments\MakeCmdArgument;


class MakeCmdArgumentTest extends \PHPUnit_Framework_TestCase {

    /**
     * The test sub directory path.
     * @var string
     */
    protected $sub_dirs;

    /**
     * The test name of the command.
     * @var string
     */
    protected $command_name;

    /**
     * The raw test argument.
     * @var string
     */
    protected $arg;

    /**
     * The CmdArgument object we are testing.
     * @var Blacksmith\Arguments\MakeCmdArgument
     */
    protected $cmd_arg;

    public function setUp()
    {
        parent::setUp();

        $this->sub_dirs     = 'path/to/subdir';
        $this->command_name = 'mycommand';
        $this->arg          = $this->sub_dirs . DIRECTORY_SEPARATOR . $this->command_name;

        $this->cmd_arg = new MakeCmdArgument($this->arg);
    }

    public function tearDown()
    {
        $this->sub_dirs     = null;
        $this->command_name = null;
        $this->arg          = null;

        $this->cmd_arg = null;

        parent::tearDown();
    }

    public function testParseArgumentProperlySetsSubDirs()
    {
        $this->assertEquals($this->sub_dirs, $this->cmd_arg->getSubDirPath());
    }

    public function testParseArgumentProperlySetsCommandName()
    {
        $this->assertEquals($this->command_name, $this->cmd_arg->getCommandName());
    }

    public function testGetRawArgumentReturnsTheOriginalArgumentPassed()
    {
        $this->assertEquals($this->arg, $this->cmd_arg->getRawArgument());
    }

    public function testGetSignatureReturnsTheExpectedSignatureOfTheNewCommand()
    {
        $expected_signature = str_replace(DIRECTORY_SEPARATOR, ":", $this->arg);
        $this->assertEquals($expected_signature, $this->cmd_arg->getSignature());
    }

    public function testGetCommandFileNameReturnsTheProspectivePhpFileNameForTheNewCommand()
    {
        $expected_command_file_name = ucfirst($this->command_name) . '.php';
        $this->assertEquals($expected_command_file_name, $this->cmd_arg->getCommandFileName());
    }

    public function testPassingCommandWithPhpExtensionDoesntAddAdditionalPhpExtension()
    {
        $sub_dirs     = 'path/to/subdir';
        $command_name = 'MyCommand.php';
        $arg          = $sub_dirs . DIRECTORY_SEPARATOR . $command_name;

        $cmd_arg = new MakeCmdArgument($arg);

        $this->assertEquals($command_name, $cmd_arg->getCommandFileName());
    }

    public function testPassingCommandWithStudlyCapsReturnsSignatureInUnderscoreNotation()
    {
        $sub_dirs     = 'path/to/subdir';
        $command_name = 'MyCommand.php';
        $arg          = $sub_dirs . DIRECTORY_SEPARATOR . $command_name;

        $cmd_arg = new MakeCmdArgument($arg);

        $expected_signature = 'path:to:subdir:my_command';

        $this->assertEquals($expected_signature, $cmd_arg->getSignature());
    }

    public function testPassingCommandWithCamelCaseReturnsSignatureInUnderscoreNotation()
    {
        $sub_dirs     = 'path/to/subdir';
        $command_name = 'myCommand.php';
        $arg          = $sub_dirs . DIRECTORY_SEPARATOR . $command_name;

        $cmd_arg = new MakeCmdArgument($arg);

        $expected_signature = 'path:to:subdir:my_command';

        $this->assertEquals($expected_signature, $cmd_arg->getSignature());
    }
}
