#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use FiftyFifty\Commands\FiftyFiftyCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new FiftyFiftyCommand());
$application->run();
