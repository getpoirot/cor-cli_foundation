<?php
namespace Module\CliFoundation;

use Module\CliFoundation\Interfaces\Command\iArgument;
use Module\CliFoundation\Interfaces\Command\iFlagOption;
use Module\CliFoundation\Interfaces\iCommand;
use Poirot\Std\Traits\tClone;


class Command
    implements iCommand
{
    use tClone;


    /** @var string */
    protected $name;
    protected $usage;
    protected $description;

    /** @var []iFlagOption */
    protected $_flags = [];
    /** @var []iArgument */
    protected $_args  = [];


    /**
     * Command constructor.
     *
     * @param string     $name
     * @param array|null $flags
     * @param string     $usage
     * @param string     $description
     */
    function __construct($name, array $flags = null, $usage = '', $description = '')
    {
        // Command Name:
        //
        $name = (string) $name;
        $this->_assertValidateName($name);
        $this->name = $name;


        // Usage + Description
        //
        $this->usage       = (string) $usage;
        $this->description = (string) $description;


        /*
         * [
         *   iFlagOption,
         *   'multiple' => 'false',
         *   ..
         * ]
         */
        if ($flags !== null) {
            foreach ($flags as $f) {
                $addFlag = \Poirot\Std\Invokable\resolveCallableWithArgs([$this, 'addFlag'], $f);
                call_user_func($addFlag);
            }
        }
    }


    /**
     * Get Command Name
     *
     * Namespace and Command can separated by colon.
     * users:reset-password
     *
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Add(s) Positional Argument For Command
     *
     * @param iArgument $arg  Argument
     * @param int       $pos  Position
     *
     * @return $this
     */
    function addArg(iArgument $arg, $pos = null)
    {
        $this->_args[] = $arg;

        return $this;
    }

    /**
     * Get Argument
     *
     * @param $pos
     *
     * @return iArgument|null
     */
    function getArg($pos)
    {
        if ( isset($this->_args[$pos]) )
            return $this->_args[$pos];

        return null;
    }

    /**
     * Get Arguments
     *
     * @return []iArgument
     */
    function getArgs()
    {
        return $this->_args;
    }

    /**
     * Add(s) Flag For Command
     *
     * @param iFlagOption $flag     Flag Options
     * @param bool        $multiple Flag option can take multiple values
     *
     * @return $this
     */
    function addFlag(iFlagOption $flag, $multiple = false)
    {
        // TODO Multiple / Shortcut

        $name = $flag->getName();
        if ( isset($this->_flags[$name]) ) {
            throw new \LogicException(sprintf(
                'A Flag Option with name "%s" already exists.'
                , $name
            ));
        }


        $this->_flags[$name] = $flag;
    }

    /**
     * Get Flag By Name
     *
     * @param string $name
     * @param null   $default
     *
     * @return iFlagOption
     */
    function getFlag($name, $default = null)
    {
        // TODO with shortcuts

        if (! isset($this->_flags[$name]) )
            return $default;


        return $this->_flags[$name];
    }

    /**
     * Gets the array of FlagOptions objects.
     *
     * @return []iFlagOption
     */
    function getFlags()
    {
        return $this->_flags;
    }

    /**
     * Get command usage message
     *
     * @return string
     */
    function getUsage()
    {
        return $this->usage;
    }

    /**
     * Get Command Description
     *
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }


    /**
     * Gets the synopsis.
     *
     * @param bool $short Whether to return the short version (with options folded) or not
     *
     * @return string The synopsis
     */
    function getSynopsis($short = false)
    {
        $elements = array();

        if ($short && $this->getOptions()) {
            $elements[] = '[options]';
        } elseif (!$short) {
            foreach ($this->getOptions() as $option) {
                $value = '';
                if ($option->acceptValue()) {
                    $value = sprintf(
                        ' %s%s%s',
                        $option->isValueOptional() ? '[' : '',
                        strtoupper($option->getName()),
                        $option->isValueOptional() ? ']' : ''
                    );
                }

                $shortcut = $option->getShortcut() ? sprintf('-%s|', $option->getShortcut()) : '';
                $elements[] = sprintf('[%s--%s%s]', $shortcut, $option->getName(), $value);
            }
        }

        if (count($elements) && $this->getArguments()) {
            $elements[] = '[--]';
        }

        foreach ($this->getArguments() as $argument) {
            $element = '<'.$argument->getName().'>';
            if (!$argument->isRequired()) {
                $element = '['.$element.']';
            } elseif ($argument->isArray()) {
                $element = $element.' ('.$element.')';
            }

            if ($argument->isArray()) {
                $element .= '...';
            }

            $elements[] = $element;
        }

        return implode(' ', $elements);
    }


    // ..

    /**
     * Validates a command name.
     *
     * It must be non-empty and parts can optionally be separated by ":".
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException When the name is invalid
     */
    private function _assertValidateName($name)
    {
        if (! preg_match('/^[^\:]++(\:[^\:]++)*$/', $name) )
            throw new \InvalidArgumentException(sprintf('Command name "%s" is invalid.', $name));

    }
}
