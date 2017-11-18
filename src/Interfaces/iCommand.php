<?php
namespace Module\CliFoundation\Interfaces;

use Module\CliFoundation\Interfaces\Command\iArgument;
use Module\CliFoundation\Interfaces\Command\iFlagOption;


interface iCommand
{
    /**
     * Get Command Name
     *
     * Namespace and Command can separated by colon.
     * users:reset-password
     *
     * @return string
     */
    function getName();

    /**
     * Add(s) Positional Argument For Command
     *
     * @param iArgument $arg  Argument
     * @param int       $pos  Position
     *
     * @return $this
     */
    function addArg(iArgument $arg, $pos = 0);

    /**
     * Get Argument
     *
     * @param $pos
     *
     * @return iArgument|null
     */
    function getArg($pos);

    /**
     * Get Arguments
     *
     * @return []iArgument
     */
    function getArgs();

    /**
     * Add(s) Flag For Command
     *
     * @param iFlagOption $flag   Flag Options
     * @param bool        $multiple Flag option can take multiple values
     *
     * @return $this
     */
    function addFlag(iFlagOption $flag, $multiple = false);

    /**
     * Get Flag By Name
     *
     * @param string $name
     * @param null   $default
     *
     * @return iFlagOption
     */
    function getFlag($name, $default = null);

    /**
     * Gets the array of FlagOptions objects.
     *
     * @return []iFlagOption
     */
    function getFlags();

    /**
     * Get command usage message
     *
     * @return string
     */
    function getUsage();

    /**
     * Get Command Description
     *
     * @return string
     */
    function getDescription();
}
