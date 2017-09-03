<?php
namespace Module\CliFoundation
{
    use Poirot\Application\aSapi;
    use Poirot\Application\Interfaces\Sapi;
    use Poirot\Application\Interfaces\iApplication;
    use Poirot\Application\Interfaces\Sapi\iSapiModule;


    class Module implements iSapiModule
        , Sapi\Module\Feature\iFeatureModuleInitSapi
    {
        /**
         * Init Module Against Application
         *
         * - determine sapi server, cli or http
         *
         * priority: 1000 A
         *
         * @param iApplication|aSapi $sapi Application Instance
         *
         * @return false|null False mean not setup with other module features (skip module)
         * @throws \Exception
         */
        function initialize($sapi)
        {
            if (! \Poirot\isCommandLine( $sapi->getSapiName() ) )
                // Sapi Is Not CLI. SKIP Module Load!!
                return false;
        }

        
    }
}