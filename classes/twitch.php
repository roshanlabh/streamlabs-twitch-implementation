<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require __DIR__ . '/../vendor/autoload.php';

class TwitchProvider
{
    private $options;
    private static $instance;

    // create a singleton object
    public static function getInstance(): TwitchProvider
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
    
    private function __construct()
    {
        $factory = new RandomLib\Factory;
        $generator = $factory->getMediumStrengthGenerator();
        $state = $generator->generateString(32, '0123456789');

        $this->options = [
            'clientId' => '3wofmtvjdwe3f19x0qt7aieqspqj78',         // The client ID assigned when you created your application
            'clientSecret' => 'h81dbruz424wm19ep1rhnc3obcuyrb',     // The client secret assigned when you created your application
            'redirectUri' => 'http://rlabh.tk/streamlabs/callback.php',   // Your redirect URL you specified when you created your application
            'state' => $state,
            'scopes' => []      // The scopes you would like to request
        ];
    }

    public function getAuthorizationUrl()
    {
        return "https://id.twitch.tv/oauth2/authorize"
        ."?client_id={$this->options['clientId']}"
        ."&response_type=code"
        ."&redirect_uri={$this->options['redirectUri']}"
        ."&state={$this->options['state']}"
        ."&force_verify=true";
    }

    public function getState()
    {
        return $this->options['state'];
    }

    public function getTokenRequestUrl(string $code)
    {
        return "https://id.twitch.tv/oauth2/token"
        ."?client_id={$this->options['clientId']}"
        ."&client_secret={$this->options['clientSecret']}"
        ."&code={$code}"
        ."&grant_type=authorization_code"
        ."&redirect_uri={$this->options['redirectUri']}";
    }

    public function getTokenRevokeUrl(string $token)
    {
        return "https://id.twitch.tv/oauth2/revoke"
        ."?client_id={$this->options['clientId']}"
        ."&token={$token}";
    }

    public function getEvents(string $channelId)
    {
        return $this->getAuthenticatedRequest('GET', "https://api.twitch.tv/v5/channels/{$channelId}/events?client_id={$this->options['clientId']}");
    }

    public function getAuthenticatedRequest(string $method, string $url)
    {
        $client = new GuzzleHttp\Client();
        $request = new GuzzleHttp\Psr7\Request($method, $url, ['Authorization'=>'Bearer '.$_SESSION['twitch_access_token']]);

        $response = $client->send($request);

        return json_decode($response->getBody()->getContents());
    }
}
