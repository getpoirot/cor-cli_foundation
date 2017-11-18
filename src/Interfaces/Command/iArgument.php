<?php
namespace Module\CliFoundation\Interfaces\Command;


interface iArgument
{
    /**
     * Get Argument Value Name (Argument Itself)
     *
     * @return mixed|null
     */
    function getValue();

    /**
     * Get Argument Description
     *
     * @return string
     */
    function getDescription();
}
