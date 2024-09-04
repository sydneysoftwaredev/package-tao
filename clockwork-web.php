<?php

require_once 'vendor/autoload.php';

$clockwork = Clockwork\Support\Vanilla\Clockwork::init(
    [
        'api' => '/clockwork-api.php?request=',
        'web' => [
            'enable' => true,
            'path' => __DIR__ . '/clockwork-web',
            'uri' => '/clockwork-web'
        ]
    ]
);

$clockwork->returnWeb();
