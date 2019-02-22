<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require __dir__ . '/vendor/autoload.php';
require 'classes/twitch.php';
session_start();

error_reporting(1);
ini_set('display_errors', 1);

$provider = TwitchProvider::getInstance();
?>