<?php

require __DIR__.'/../vendor/autoload.php';

use TwelveDays\Command\generateLyrics;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new generateLyrics());
$application->run();