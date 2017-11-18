<?php
namespace Module\CliFoundation\Interfaces\Command;


interface iFlagOption
{
    /**
     * The option name
     *
     * @return string
     */
    function getName();

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
    function setValue($value = true);

    /**
     * Get Option Value Or Null
     *
     * @return mixed|null
     */
    function getValue();

    /**
     * Get Flag Option Description
     *
     * @return string
     */
    function getDescription();

    /**
     * Get Options Shortcut
     *
     * @return null|array
     */
    function getShortcuts();
}
