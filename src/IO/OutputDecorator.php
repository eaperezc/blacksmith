<?php

namespace Blacksmith\IO;

/**
 * Output decorator class
 *
 * Helps to make the terminal output more
 * colorful, adding colors to the letters.
 */
class OutputDecorator {

    /**
     * Foreground Colors
     *
     * This are the available colors for the letters
     * and its translation value to the console
     */
    private $foreground_colors = [
        'black'         => '0;30',
        'dark_gray'     => '1;30',
        'light_blue'    => '1;34',
        'green'         => '0;32',
        'light_green'   => '1;32',
        'cyan'          => '0;36',
        'light_cyan'    => '1;36',
        'red'           => '0;31',
        'light_red'     => '1;31',
        'purple'        => '0;35',
        'light_purple'  => '1;35',
        'brown'         => '0;33',
        'yellow'        => '0;33',
        'bold_yellow'   => '1;33',
        'light_gray'    => '0;37',
        'white'         => '1;37'
    ];

    /**
     * Background Colors
     *
     * This are the available colors for the background
     * and its translation value to the console. Highlight.
     */
    private $background_colors = [
        'black'         => '40',
        'red'           => '41',
        'green'         => '42',
        'yellow'        => '43',
        'blue'          => '44',
        'magenta'       => '45',
        'cyan'          => '46',
        'light_gray'    => '47'
    ];


    /**
     * Decorate Method
     *
     * This is the method that will take the string given to it and
     * transforms it to a string that will add the colors in the terminal.
     */
    public function decorate($string, $foreground_color = null, $background_color = null)
    {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

}
