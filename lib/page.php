<?php
  // Globals $page, $event, $projects, $person, $error and $saved are assumed to exist
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Amilia Innovation Day</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="/favicon.png" rel="apple-touch-icon" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="mobileoptimized" content="0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/chart.min.js" type="text/javascript"></script>
    <script src="/js/app.js?<?=rand()?>" type="text/javascript"></script>

    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css?<?=rand()?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Amaranth|Dancing+Script" rel="stylesheet">
    <script>
      window.app = {
        event: <?=json_encode($event)?>,
        projects: <?=json_encode($projects)?>,
        person: <?=json_encode($person)?>,
        page: '<?=$page?>'
      };
    </script>
  </head>

  <body>
    <header>
      <h4>
        <img src="/favicon.png" />&nbsp;&nbsp;Amilia Innovation Day
        <a href="admin.php" class="pull-right"><i class="fa fa-fw fa-cog"></i></a>
      </h4>
    </header>

    <?php require $page.'_view.php'; ?>

    <br/><br/><br/><br/>

    <footer>
      <a href="/" class="home footer-btn <?=$page == 'home' ? 'selected': ''?>"><i class="fa fa-fw fa-home"></i></a>
      <a href="/vote.php" class="vote footer-btn <?=$page == 'vote' ? 'selected': ''?>"><i class="fa fa-fw fa-check-square-o"></i></a>
      <a href="/results.php" class="results footer-btn <?=$page == 'results' ? 'selected': ''?>"><i class="fa fa-fw fa-bar-chart"></i></a>
    </footer>

  </body>
</html>
