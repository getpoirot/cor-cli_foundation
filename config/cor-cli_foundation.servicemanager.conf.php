<?php
use Module\CliFoundation\Interfaces\iConsoleRequest;
use Module\CliFoundation\Services\ServiceConsoleRequest;


return [
    'implementations' => [
        'ConsoleRequest' => iConsoleRequest::class,
    ],
    'services' => [
        'ConsoleRequest' => ServiceConsoleRequest::class,
        'ConsoleRouter'  => \Module\CliFoundation\Services\ServiceConsoleRouter::class,
    ],
];
