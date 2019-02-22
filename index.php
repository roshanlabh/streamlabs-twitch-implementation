<?php

/**
 * @author Roshan Labh
 * @copyright 2019
 */

require_once 'includes.php';
$_SESSION['state'] = $provider->getState();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<title>Login - streamlabs</title>
<!-- Bootstrap core CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
<style type="text/css">
a:hover { text-decoration: none; }
.bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
@media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; } }
</style>
<!-- Custom styles for this template -->
<link href="https://getbootstrap.com/docs/4.3/examples/sign-in/signin.css" rel="stylesheet" />
</head>
<body class="text-center">
<div class="form-signin">
  <img class="mb-4" src="assets/img/stream.png" alt="logo" />
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <a href="<?php echo $provider->getAuthorizationUrl(); ?>">
    <button class="btn btn-lg btn-primary btn-block" type="button">Login with twitch</button>
  </a>
  <p class="mt-5 mb-3 text-muted">&copy; 2019-2020</p>
</div>
</body>
</html>
