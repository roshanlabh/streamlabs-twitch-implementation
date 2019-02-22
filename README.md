## Demo URL
    http://rlabh.tk/streamlabs/
    
## Usage
    To make this app work properly. You should have
    - PHP 7+ (with required extensions enabled)
    - composer
    installed on your system.
    Or one can even use PHP's official docker image.

    After that, follow below steps
    - Clone the repo.
    - Run 
        cd `repo-dir` & composer install
    - Change clientId, clientSecret, redirectUri in classes/twitch.php
    That's all.

## Specifications

0. You are required to build an application which exposes two simple pages to the browser

1. The first/home page lets a user login with Twitch and set their favorite Twitch streamer name. This initiates a backend event
   listener which listens to all events for given streamer.
    > Done. So first page lets the user to login with his/her Twitch account. After successful login, it redirects user to home.php where they can search their favorite streamer by name. And by default it shows live chat window and upcoming events of the logged in user.

2. The second/streamer page shows an embedded livestream, chat and list of 10 most recent events for your favorite streamer. This page
   doesn’t poll the backend and rather leverages web sockets and relevant Twitch API.
   > Done. On home.php, you will be able to see top 10 events of logged in OR searched user.
    
    * Event Mangaer API
    [https://discuss.dev.twitch.tv/t/event-manager-api/9802/3]
    According to this, Twitch don't have official events api for third party use. Hence it is un-documented and so it can change any time.

3. Additionally please answer following questions at the bottom of your `README`:
- How would you deploy the above on AWS? (ideally a rough architecture diagram will help)
> As already mentioned above, this project has very few dependency. So it can be easily deployed with docker or a webserver(apach2/ngnix) and PHP, which can be further automated through any CI/CD tool like Jenkins to automate the build process for deployment.
And to talk about the architecture, so in AWS context, I will use AWS Auto Scaling service, which ensures the high availablity of the system. By setting Auto scaling policy, it will automatically put new server in place depending on the traffic or load.

-------------+         +---------------------------+          +--------------+        +------------------------------+
| Request(s) | ======> | Application Load Balancer | =======> | Auto Scaling | =====> | Launch Application Server(s) |
-------------+         +---------------------------+          +--------------+        +------------------------------+

- Where do you see bottlenecks in your proposed architecture and how would you approach scaling this app starting from 100 reqs/day to
   900MM reqs/day over 6 months?
    This is very subjective one. For me, scaling is a discplined practice, which depends on the cost and time factor.
    This application is mainly having only two components a web server and PHP for counsuming 3rd party API (in this case Twitch). So our all request go to Twitch API for processing and then it response back with result. Therefore, understanding Twitch limit is also very important. As per Twitch documentation [https://dev.twitch.tv/docs/api/guide/#rate-limits], it allows 800 reqs/min only, which comes to 1152000 (800*60*24) reqs/day. Since our target is of 900 million reqs/day, then in this case either we can use multiple API keys or we can cache the response for some interval to avoid hitting same API again and again.

    Also, to better scale an application, I would first understand the bottlenect area. And then work on it to resolve the same by either adding more power to existing machine (Vertical scaling), adding more servers (Horitzontal scaling)or optimize the existing code.

## References
* For managing Twitch Apps
[https://glass.twitch.tv/console/apps]

* To create a new event on Twitch
[https://www.twitch.tv/roshanlabh/events, https://www.twitch.tv/roshanlabh/dashboard/events]

* Twitch Authentication PHP Sample
[https://github.com/twitchdev/authentication-samples/tree/master/php]

* Bootstrap
[https://getbootstrap.com/docs/4.3/getting-started/introduction/]