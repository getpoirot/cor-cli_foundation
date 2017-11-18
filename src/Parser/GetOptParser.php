<?php
namespace Module\CliFoundation\Parser;

/*
$options = array(
    'a',        // short flag -a, parameter is not allowed
    'b:',       // short flag -b, parameter is required
    'c::',      // short flag -c, parameter is optional
    'foo',      // long option --foo, parameter is not allowed
    'bar:',     // long option --bar, parameter is required
    'baz::',    // long option --baz, parameter is optional
    'g*::',     // short flag -g, parameter is optional, multi-pass
);
*/

use Module\CliFoundation\Command;
use Module\CliFoundation\Interfaces\iCommand;
use Module\CliFoundation\Interfaces\iParser;
use Module\CliFoundation\Parser\GetOpt\OptionDefinition;


class GetOptParser
    implements iParser
{
    /** @var array */
    protected $options = [];
    /** @var OptionDefinition */
    protected $option_factory;


    /**
     * GetOptParser constructor.
     *
     * @param array $options
     */
    function __construct(array $options = null)
    {
        if ($options !== null)
            $this->setOptions($options);


        $this->option_factory = new OptionDefinition;
    }


    /**
     * Parse Input To Command
     *
     * @param $input
     *
     * @return iCommand
     */
    function parseToCommand($input)
    {
        $command = new Command('request-command');



    }


    // Options

    /**
     * Sets the options to be used when parsing input.
     *
     * @param array $options The array of option definitions.
     */
    function setOptions(array $options)
    {
        $this->options = [];
        foreach ($options as $string => $descr)
            $this->_setOption($string, $descr);
    }


    // ..

    /**
     * Sets one option to be used when parsing input.
     *
     * @param string $string The option definition string.
     * @param string $descr  The option help description.
     *
     */
    protected function _setOption($string, $descr)
    {
        $option = $this->option_factory->newInstance($string, $descr);

        if (! $option->name)
            $this->options[] = $option;
        else
            $this->options[$option->name] = $option;
    }

    /**
     * @param $name
     *
     * @return \StdClass
     */
    protected function _getOptionDefinition($name)
    {
        if (isset($this->options[$name]))
            return $this->options[$name];


        return null;
    }


    /**
     * Sets the value for a long option.
     *
     * @param string $arg The current input element,
     *        e.g. "--foo" or "--bar=baz" or "--bar baz".
     *
     * @return array
     */
    private function _setLongOptionValue($arg)
    {
        $pos = strpos($arg, '=');
        if ($pos === false) {
            // --option Value | --option
            $name = $arg;
            $value = true;
            $option = $this->_getOptionDefinition($name);
            if ($option->param == 'required')
                // Value is required;
                $value = array_shift($arg);

        } else {
            // --option=value
            $name  = substr($arg, 0, $pos);
            $value = substr($arg, $pos + 1);
        }


        return [$name, $value];
    }
}
