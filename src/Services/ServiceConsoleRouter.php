<?php
namespace Module\CliFoundation\Services;

use Module\CliFoundation\Router\ConsoleRouter;
use Module\QueueDriver\Actions\Worker\FireWorkerAction;
use Poirot\Application\aSapi;
use Poirot\Ioc\Container\Service\aServiceContainer;

use Poirot\Std\Struct\DataEntity;


class ServiceConsoleRouter
    extends aServiceContainer
{
    const CONF   = 'console_commands';

    /** @var string Service Name */
    protected $name = 'ConsoleRouter';


    /**
     * Create Service
     *
     * @return ConsoleRouter
     */
    function newService()
    {
        $consoleRouter = new ConsoleRouter;


        // TODO add commands from config
        $consoleRouter->addCommand('workers', [
            'action' => FireWorkerAction::class
        ]);

        return $consoleRouter;
    }


    // ..

    protected function _getConfig($key = null)
    {
        # Setup By Configs:
        $services = $this->services();

        /** @var aSapi $config */
        $config   = $services->get('/sapi');
        $config   = $config->config();
        /** @var DataEntity $config */
        $config   = $config->get(self::CONF, []);

        
        if ($key !== null)
            return isset($config[$key]) ? $config[$key] : false;
        
        return $config;
    }
}
