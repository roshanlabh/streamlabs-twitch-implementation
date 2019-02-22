<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require_once 'includes.php';

if($_SESSION['twitch_access_token']) {
    try {
        $client = new GuzzleHttp\Client();
        $req = $client->request('POST', $provider->getTokenRevokeUrl($_SESSION['twitch_access_token']));
    } catch (Exception $e) {
        exit('Caught exception: '.$e->getMessage());
    }
}

unset($_SESSION);
session_destroy();
header('Location: index.php');
exit;