<?php

set_include_path(__DIR__ . '/../library' . DIRECTORY_SEPARATOR . get_include_path());

/** @see Braincrafted\HttpEcho\HttpEcho */
require_once 'Braincrafted/HttpEcho/HttpEcho.php';

use Braincrafted\HttpEcho\HttpEcho;

$httpEcho = new HttpEcho($_SERVER, $_GET, $_POST, $_COOKIE);
header('Content-type: text');
echo $httpEcho->asText();
