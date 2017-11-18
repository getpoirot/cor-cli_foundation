<?php
namespace Module\CliFoundation
{

    use Module\CliFoundation\Events\Dispatch\DispatchCommandListener;
    use Poirot\Ioc\Container;
    use Poirot\Application\Interfaces\Sapi;
    use Poirot\Application\Interfaces\Sapi\iSapiModule;
    use Poirot\Application\ModuleManager\Interfaces\iModuleManager;
    use Poirot\Application\Sapi\Event\EventHeapOfSapi;
    use Poirot\Loader\Autoloader\LoaderAutoloadAggregate;
    use Poirot\Loader\Autoloader\LoaderAutoloadNamespace;
    use Poirot\Std\Interfaces\Struct\iDataEntity;
    use Module\CliFoundation\Events\MatchRequest\MatchReqCommandListener;


    class Module implements iSapiModule
        , Sapi\Module\Feature\iFeatureModuleInitSapi
        , Sapi\Module\Feature\iFeatureModuleAutoload
        , Sapi\Module\Feature\iFeatureModuleInitModuleManager
        , Sapi\Module\Feature\iFeatureModuleMergeConfig
        , Sapi\Module\Feature\iFeatureModuleInitServices
        , Sapi\Module\Feature\iFeatureModuleInitSapiEvents
    {
        /**
         * @inheritdoc
         */
        function initialize($sapi)
        {
            if (! \Poirot\isCommandLine( $sapi->getSapiName() ) )
                // Sapi Is Not CLI. SKIP Module Load!!
                return false;
        }

        /**
         * @inheritdoc
         */
        function initAutoload(LoaderAutoloadAggregate $baseAutoloader)
        {
            #$nameSpaceLoader = \Poirot\Loader\Autoloader\LoaderAutoloadNamespace::class;
            $nameSpaceLoader = 'Poirot\Loader\Autoloader\LoaderAutoloadNamespace';
            /** @var LoaderAutoloadNamespace $nameSpaceLoader */
            $nameSpaceLoader = $baseAutoloader->loader($nameSpaceLoader);
            $nameSpaceLoader->addResource(__NAMESPACE__, __DIR__);
        }

        /**
         * @inheritdoc
         */
        function initModuleManager(iModuleManager $moduleManager)
        {
            // ( ! ) ORDER IS MANDATORY

            if (! $moduleManager->hasLoaded('Foundation') )
                // Module Is Required.
                $moduleManager->loadModule('Foundation');

        }

        /**
         * @inheritdoc
         */
        function initConfig(iDataEntity $config)
        {
            return \Poirot\Config\load(__DIR__ . '/../config/cor-cli_foundation');
        }

        /**
         * @inheritdoc
         */
        function initServiceManager(Container $services)
        {
            return \Poirot\Config\load(__DIR__ . '/../config/cor-cli_foundation.servicemanager');
        }

        /**
         * @inheritdoc
         */
        function initSapiEvents(EventHeapOfSapi $events)
        {
            // EVENT: Sapi Request Match .......................................................

            # match request then followed by dispatch
            $events->on(
                EventHeapOfSapi::EVENT_APP_MATCH_REQUEST
                , new MatchReqCommandListener
                , -10
            );

            # dispatch matched route
            $events->on(
                EventHeapOfSapi::EVENT_APP_DISPATCH
                , new DispatchCommandListener
                , -1000
            );
        }
    }
}
