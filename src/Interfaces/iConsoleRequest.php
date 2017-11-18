<?php
namespace Module\CliFoundation\Interfaces;

use Poirot\Std\Exceptions\exImmutable;
use Poirot\Std\Interfaces\Struct\iData;
use Poirot\Std\Struct\DataEntity;


interface iConsoleRequest
{
    /**
     * Give Script Name To Request Console
     *
     * @param string $scriptName
     *
     * @return $this
     * @throws exImmutable
     */
    function giveScriptName($scriptName);

    /**
     * Get Script Name
     *
     * @return string
     */
    function getScriptName();

    /**
     * Give Command Name
     *
     * @param string $command
     *
     * @return $this
     */
    function giveCommand($command);

    /**
     * Get Request Command
     *
     * @return string
     */
    function getCommand();

    /**
     * Give Request Arguments
     *
     * @param array $args
     *
     * @return $this
     * @throws exImmutable
     */
    function giveArgs(array $args);

    /**
     * Request Command Arguments
     *
     * @return array
     */
    function getArgs();

    /**
     * Set Meta Data
     *
     * @param array|\Traversable$metas
     *
     * @return $this
     */
    function setMetaData($metas);

    /**
     * Set Meta Key
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    function addMeta($key, $value);

    /**
     * Meta Data Associated With Request
     *
     * @return iData|DataEntity
     */
    function getMeta();
}
