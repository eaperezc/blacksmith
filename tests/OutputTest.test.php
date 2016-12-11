<?php

namespace Blacksmith\IO;

use Blacksmith\IO\Output;


class OutputTest extends \PHPUnit_Framework_TestCase {


    private $output = null;


    protected function setUp()
    {
        $this->output = new Output;
    }


    public function testEmptyParametersPrintLn()
    {
        $result = $this->output->println();
        $this->assertEquals("\r\n", $result);
    }


    public function testMessageParameterOnlyPrintLn()
    {
        $result = $this->output->println("A message here");
        $this->assertEquals("A message here\r\n", $result);
    }


    public function testMessageParameterWithColorPrintLn()
    {
        $result = $this->output->println("A message here", "yellow");
        $this->assertEquals("\033[0;33mA message here\033[0m\r\n", $result);
    }

}


// Override for the global fwrite function
function fwrite($type, $message) {
    return $message;
}
