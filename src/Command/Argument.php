<?php
namespace Module\CliFoundation\Command;

use Module\CliFoundation\Interfaces\Command\iArgument;


class Argument
    implements iArgument
{
    /** @var string */
    protected $value;
    /** @var array|null */
    protected $shortcut = [];
    /** @var string */
    protected $description = '';


    /**
     * Constructor.
     *
     * @param string     $value        The option name
     * @param string     $description A description text
     */
    function __construct($value, $description = '')
    {
        $value = (string) $value;
        if ( empty($value) )
            throw new \InvalidArgumentException('An argument name cannot be empty.');

        $this->value        = $value;
        $this->description = $description;
    }


    /**
     * The option name
     *
     * @return string
     */
    function getValue()
    {
        return $this->value;
    }

    /**
     * Set Value Of Option
     *
     * options with default value mean Optional
     * otherwise any Option Flag must have value and
     * considered as Required.
     *
     * @param mixed $value
     *
     * @return $this
     */
    function setValue($value)
    {
        $this->value = (string) $value;
        return $this;
    }

    /**
     * Get Flag Option Description
     *
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }
}
