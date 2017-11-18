<?php
namespace Module\CliFoundation\Interfaces;


interface iParser
{
    /**
     * Parse Input To Command
     *
     * @param $input
     *
     * @return iCommand
     */
    function parseToCommand($input);
}
