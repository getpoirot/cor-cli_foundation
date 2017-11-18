<?php
namespace Module\CliFoundation\Console;

use Poirot\Std\ConfigurableSetter;
use Poirot\Std\Exceptions\exImmutable;
use Module\CliFoundation\Interfaces\iConsoleRequest;
use Poirot\Std\Interfaces\Struct\iData;
use Poirot\Std\Struct\DataEntity;


class ConsoleRequest
    extends ConfigurableSetter
    implements iConsoleRequest
{
    /** @var string */
    protected $scriptName;
    protected $command;
    protected $args = [];
    /** @var iData */
    protected $meta;


    /**
     * Give Script Name To Request Console
     *
     * @param string $scriptName
     *
     * @return $this
     */
    function giveScriptName($scriptName)
    {
        if ($this->scriptName)
            throw new exImmutable(sprintf(
                'Script name given before; as "%s".'
                , $this->getScriptName()
            ));


        $this->scriptName = (string) $scriptName;
        return $this;
    }

    /**
     * Get Script Name
     *
     * @return string
     */
    function getScriptName()
    {
        return $this->scriptName;
    }

    /**
     * Give Command Name
     *
     * @param string $command
     *
     * @return $this
     */
    function giveCommand($command)
    {
        if ($this->command)
            throw new exImmutable(sprintf(
                'Command name given before; as "%s".'
                , $this->getCommand()
            ));


        $this->command = (string) $command;
        return $this;
    }

    /**
     * Get Request Command
     *
     * @return string
     */
    function getCommand()
    {
        return $this->command;
    }

    /**
     * Give Request Arguments
     *
     * @param array $args
     *
     * @return $this
     * @throws exImmutable
     */
    function giveArgs(array $args)
    {
        if ($this->args)
            throw new exImmutable( 'Arguments given before.');


        $this->args = $args;
        return $this;
    }

    /**
     * Request Command Arguments
     *
     * @return array
     */
    function getArgs()
    {
        return $this->args;
    }

    /**
     * Set Meta Data
     *
     * @param array|\Traversable$metas
     *
     * @return $this
     */
    function setMetaData($metas)
    {
        $this->getMeta()->clean();

        foreach ($metas as $key => $val)
            $this->addMeta($key, $val);

        return $this;
    }

    /**
     * Set Meta Key
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    function addMeta($key, $value)
    {
        $this->getMeta()->import([
            $key => $value
        ]);

        return $this;
    }

    /**
     * Meta Data Associated With Request
     *
     * @return iData|DataEntity
     */
    function getMeta()
    {
        if ($this->meta === null)
            $this->meta = new DataEntity;

        return $this->meta;
    }
}
