<?php
namespace App;
ini_set('memory_limit', '-1');
require __DIR__ . '/../vendor/autoload.php';

use App\Components\ParseBbsComponent;

$url = $argv[1];

$app = new ParseBbsComponent($url);
$app->run();
