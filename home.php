<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require_once 'includes.php';

// If no access token, then redirect to login page
if(!$_SESSION['twitch_access_token'])
  header('Location: index.php');

$streamername = empty($_POST['streamername']) ? '' : $_POST['streamername'];
$queryString = empty($streamername) ? '' : '?login=' . $streamername;
$response = $provider->getAuthenticatedRequest('GET', "https://api.twitch.tv/helix/users{$queryString}");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<title>Home - streamlabs</title>
<!-- Bootstrap core CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<style>
.bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
@media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; } }
body { padding-top:5rem; }
.starter-template { padding:3rem 1.5rem; text-align:center; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">
    <img src="assets/img/logo-transparent.png" height="30" alt="logo"/>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <form class="form-inline my-2 my-lg-0" method="post">
      <input class="form-control mr-sm-2" type="text" name="streamername" placeholder="Search streamer" aria-label="Search streamer" value="<?php echo $streamername; ?>"/>
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
  <a class="navbar-brand" href="logout.php">Logout</a>
</nav>

<main role="main" class="container">
  <?php if(!empty($response->data)) { ?>
    <div class="embed-responsive embed-responsive-21by9">
        <!-- Add a placeholder for the Twitch embed -->
        <div class="embed-responsive-item" id="twitch-embed"></div>
    
        <!-- Load the Twitch embed script -->
        <script src="https://embed.twitch.tv/embed/v1.js"></script>
    
        <!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
        <script type="text/javascript">
          new Twitch.Embed("twitch-embed", {
            channel: "<?php echo $response->data[0]->display_name; ?>"
          });
        </script>
    </div>
    
    <?php $events = $provider->getEvents($response->data[0]->id); ?>
    <div class="list-group mt-5 h-25">
        <h3>Events</h3>
        <?php if(!empty($events->_total)) {
          // echo "<pre>"; print_r($events);
          $count = $events->_total <= 10 ? $events->_total : 10;
          for ($i=0; $i < $count; $i++) {
        ?>
        <div class="card mb-3">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?php echo str_replace(['{width}','{height}'], '250', $events->events[$i]->cover_image_url); ?>" class="card-img" alt="..." />
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title"><?php echo $events->events[$i]->title; ?></h4>
                <p class="card-text"><strong>Description: </strong><?php echo $events->events[$i]->description; ?></p>
                <p class="card-text"><strong>Streaming: </strong><?php echo $events->events[$i]->game->name; ?></p>
                <p class="card-text"><strong>Date & Time: </strong>From: <?php echo date_format(date_create($events->events[$i]->start_time), 'l M j, h:i A'). ' to '. date_format(date_create($events->events[$i]->end_time), 'l M j, h:i A'); ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php } else { ?>
          <div class="alert alert-danger" role="alert">
            There are no events!
          </div>
        <?php } ?>
    </div>
  <?php } else { ?>
  <div class="alert alert-danger" role="alert"> No streamer found! </div>
  <?php } ?>
</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/4.3/dist/js/bootstrap.bundle.min.js"></script></body>
</html>
