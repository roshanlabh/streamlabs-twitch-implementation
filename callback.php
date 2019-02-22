<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require_once 'includes.php';

// match request state and response state
if ($_SESSION['state'] === $_GET['state']) {
    if(!empty($_GET['code'])) {
        $client = new GuzzleHttp\Client();
        $request = $client->request('POST', $provider->getTokenRequestUrl($_GET['code']));

        $response = json_decode($request->getBody());
        $_SESSION['twitch_access_token'] = $response->access_token;     // store token in session for further uses
        header('Location: home.php');
    } else {
        header('Location: index.php?error='.$_GET['error']);
    }
    exit;
} else {
    header('Location: index.php?error=state_mismatch');
    exit;
}
