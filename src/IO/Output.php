<?php

namespace Blacksmith\IO;

use Blacksmith\IO\OutputDecorator;

/**
 * Output Helper
 *
 * This class has the object that will be living in the
 * console class that will take care of dealing with
 * printing messages to the user.
 */

class Output {

    /**
     * Object that adds color to the messages
     * @see OutputDecorator
     */
    private $decorator;


    function __construct()
    {
        $this->decorator = new OutputDecorator;
    }

    /**
     * Print a line to the terminal
     */
    public function println($message = '', $color = null, $caret_return_char = "\r\n")
    {
        // If theres a color passed as a parameter
        // we paint the message in the requested color
        if ($color) {
            $message = $this->decorator->decorate($message, $color);
        }

        return fwrite(STDOUT, $message . $caret_return_char);
    }

    /**
     * Print a line to the terminal
     */
    public function printlns(array $messages = [], $color = null, $caret_return_char = "\r\n")
    {
        foreach ($messages as $msg) {
            // print line by line of the array elements
            $this->println($msg, $color);
        }
    }

    /**
     * Warning message
     * Prints a warning message to the console
     */
    public function warning($message)
    {
        $output = $this->decorator->decorate("  " . $message . "  ", 'black', 'yellow');
        $this->println($output);

    }

    /**
     * Alert message
     * Prints an alert message to the console
     */
    public function alert($message)
    {
        $output = $this->decorator->decorate("  " . $message . "  ", 'black', 'red');
        $this->println($output);
    }

    /**
     * Success message
     * Prints a success message to the console
     */
    public function success($message)
    {
        $output = $this->decorator->decorate($message, 'green');
        $this->println($output);
    }
}
