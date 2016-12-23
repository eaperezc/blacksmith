<?php

namespace Blacksmith;

/**
 * The Argument Class
 *
 * This class is the base class that holds common properties and
 * functionality across all types of Argument objects that inherit
 * from this class.
 */
abstract class Argument {

    /**
     * The raw argument that was passed in by the user.
     * @var string
     */
    protected $raw_arg;

    /**
     * Constructor
     *
     * @param string $raw_arg
     *      The raw argument provided by the user.
     */
    public function __construct($raw_arg)
    {
        $this->raw_arg = $raw_arg;
    }

    /**
     * Return the raw argument.
     *
     * @return string
     */
    public function getRawArgument()
    {
        return $this->raw_arg;
    }
}