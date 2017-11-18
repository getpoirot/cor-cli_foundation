<?php
namespace Module\CliFoundation\Router;

use Module\CliFoundation\Interfaces\iCommand;
use Module\CliFoundation\Interfaces\iConsoleRequest;
use Module\CliFoundation\Interfaces\iParser;
use Module\CliFoundation\Parser\ArgParser;


class ConsoleRouter
    extends aConsoleRouter
{
    /** @var array */
    protected $commands = [];
    /** @var ArgParser */
    protected $_parser;


    /**
     * Match with Request
     *
     * - on match extract request params and merge
     *   into default params
     *
     * !! don`t change request object attributes
     *
     * @param iConsoleRequest $request
     *
     * @return iCommand|false
     */
    function match(iConsoleRequest $request)
    {
        $commandName = $request->getCommand();

        if (! isset($this->commands[$commandName]) )
            return false;


        $commandData = $this->commands[$commandName];

        /** @var ArgParser $parser */
        $parser    = isset($commandData['parser']) ? $commandData['parser'] : $this->_getDefaultParser();
        $command   = $parser->parseToCommand($request->getArgs());

        // Add Meta Data For Matched Command Into Request
        foreach ($commandData['params'] as $k => $v)
            $request->addMeta($k, $v);


        return $command;
    }


    function addCommand($commandName, $params, iParser $parser = null)
    {
        $this->commands[$commandName] = [
            'parser' => $parser,
            'params' => $params,
        ];
    }


    // ..

    private function _getDefaultParser()
    {
        if (! $this->_parser)
            $this->_parser = new ArgParser;

        return $this->_parser;
    }
}
