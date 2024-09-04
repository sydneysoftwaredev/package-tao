<?php

require_once 'vendor/autoload.php';

$clockwork = Clockwork\Support\Vanilla\Clockwork::init(['api' => '/clockwork-api.php?request=']);

$clockwork->returnMetadata();
