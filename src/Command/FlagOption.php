<?php
namespace Module\CliFoundation\Command;

use Module\CliFoundation\Interfaces\Command\iFlagOption;


class FlagOption
    implements iFlagOption
{
    /** @var string */
    protected $name;
    /** @var mixed */
    protected $value;
    /** @var array|null */
    protected $shortcut = [];
    /** @var string */
    protected $description = '';


    /**
     * FlagOption constructor.
     *
     * @param string     $name        The option name
     * @param bool       $value       The default value; if set null flag determine as required
     * @param string     $description A description text
     * @param array|null $shorts      The shortcuts
     */
    function __construct($name, $value = false, $description = '', array $shorts = null)
    {
        $name = (string) $name;

        if ( 0 === strpos($name, '--') )
            $name = substr($name, 2);

        if ( empty($name) )
            throw new \InvalidArgumentException('An option name cannot be empty.');


        if (null !== $shorts) {
            if (is_array($shorts))
                $shorts = implode('|', $shorts);

            $shorts = preg_split('{(\|)-?}', ltrim($shorts, '-'));
            $shorts = array_filter($shorts);
            $shorts = implode('|', $shorts);

            if ( empty($shorts) )
                throw new \InvalidArgumentException('An option shortcut cannot be empty.');
        }

        $this->name        = $name;
        $this->shortcut    = $shorts;
        $this->description = $description;

        $this->setValue($value);
    }


    /**
     * The option name
     *
     * @return string
     */
    function getName()
    {
        return $this->name;
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
    function setValue($value = true)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get Option Value Or Null
     *
     * @return mixed|null
     */
    function getValue()
    {
        return $this->value;
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

    /**
     * Get Options Shortcut
     *
     * @return null|array
     */
    function getShortcuts()
    {
        return $this->shortcut;
    }
}
