<?php
  // Globals $page, $projects, $person, $error and $saved are assumed to exist
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
    <script src="/js/app.js" type="text/javascript"></script>

    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Amaranth|Dancing+Script" rel="stylesheet">
    <script>
      window.projects = <?=json_encode($projects)?>;
      window.person = <?=json_encode($person)?>;
      window.page = '<?=$page?>';
    </script>
  </head>

  <body>
    <header>
      <h4><img src="/favicon.png" />&nbsp;&nbsp;Amilia Innovation Day</h4>
    </header>

    <?php if ($page == 'home'): ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="splash"><img src="/img/trophy-circle.png" alt="trophy" /></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <h1><?=TITLE?></h1>
            <h2></h2>
            <br/>
            <p><a href="vote.php" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-check-square-o"></i> Cast your vote</a></p>
          </div>
        </div>
      </div>

    <?php elseif ($page == 'vote'): ?>

      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <form action="/submit.php">
              <input type="hidden" name="id" value="<?=$person['id']?>" />
              <?php if ($saved): ?>
                <p class="text-success text-center lead"><i class="fa fa-fw fa-check"></i> Your vote was saved!</p>
              <?php endif; ?>

              <?php $er = is_array($error) && array_key_exists('name', $error) ? $error['name'] : NULL; ?>
              <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
                <label class="control-label">Your name</label>
                <input class="form-control" type="text" name="name" value="<?=$person['name']?>" <?=$saved ? 'disabled="disabled"' : ''?> />
                <?php if ($er != NULL): ?>
                  <div class="help-block"><?=$er?></div>
                <?php endif; ?>
              </div>

              <?php $er = is_array($error) && array_key_exists('vote1_project_id', $error) ? $error['vote1_project_id'] : NULL; ?>
              <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
                <label class="control-label">Best overall</label>
                <select class="form-control" name="vote1_project_id" <?=$saved ? 'disabled="disabled"' : ''?>>
                  <?php foreach ($projects as $project): ?>
                    <option value="<?=$project['id']?>" <?=$project['id'] == $person['vote1_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
                  <?php endforeach; ?>>
                </select>
                <?php if ($er != NULL): ?>
                  <div class="help-block"><?=$er?></div>
                <?php endif; ?>
              </div>

              <?php $er = is_array($error) && array_key_exists('vote2_project_id', $error) ? $error['vote2_project_id'] : NULL; ?>
              <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
                <label class="control-label">Best presentation</label>
                <select class="form-control" name="vote2_project_id" <?=$saved ? 'disabled="disabled"' : ''?>>
                  <?php foreach ($projects as $project): ?>
                    <option value="<?=$project['id']?>" <?=$project['id'] == $person['vote2_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
                  <?php endforeach; ?>>
                </select>
                <?php if ($er != NULL): ?>
                  <div class="help-block"><?=$er?></div>
                <?php endif; ?>
              </div>

              <?php $er = is_array($error) && array_key_exists('vote3_project_id', $error) ? $error['vote3_project_id'] : NULL; ?>
              <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
                <label class="control-label">Best MVP</label>
                <select class="form-control" name="vote3_project_id" <?=$saved ? 'disabled="disabled"' : ''?>>
                  <?php foreach ($projects as $project): ?>
                    <option value="<?=$project['id']?>" <?=$project['id'] == $person['vote3_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
                  <?php endforeach; ?>>
                </select>
                <?php if ($er != NULL): ?>
                  <div class="help-block"><?=$er?></div>
                <?php endif; ?>
              </div>

              <br/>
              <?php if ($saved === TRUE): ?>
                <a class="btn btn-success btn-lg btn-block" href="/results.php">Go see results</a>
                <a class="btn btn-default btn-block submit-again" href="#">Vote again</a>
                <button class="btn btn-primary btn-lg btn-block" type="submit" style="display: none;">Submit</button>
              <?php elseif (is_array($error)): ?>
                <p class="text-danger text-center lead"><i class="fa fa-fw fa-warning"></i> Fix 'em errors and try again.</p>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Submit again</button>
              <?php else: ?>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>

    <?php elseif ($page == 'results'): ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <h1><i class="fa fa-fw fa-trophy"></i> <?=VOTE1_NAME?></h1>
            <div class="chart-container"><canvas class="votes" data-vote="vote1"></canvas></div>
          </div>
          <div class="col-md-4">
            <h1><i class="fa fa-fw fa-smile-o"></i> <?=VOTE2_NAME?></h1>
            <div class="chart-container"><canvas class="votes" data-vote="vote2"></canvas></div>
          </div>
          <div class="col-md-4">
            <h1><i class="fa fa-fw fa-smile-o"></i> <?=VOTE3_NAME?></h1>
            <div class="chart-container"><canvas class="votes" data-vote="vote3"></canvas></div>
          </div>
        </div>
      </div>

    <?php endif; ?>

    <br/><br/><br/><br/>

    <footer>
      <a href="/" class="home footer-btn <?=$page == 'home' ? 'selected': ''?>"><i class="fa fa-fw fa-home"></i></a>
      <a href="/vote.php" class="vote footer-btn <?=$page == 'vote' ? 'selected': ''?>"><i class="fa fa-fw fa-check-square-o"></i></a>
      <a href="/results.php" class="results footer-btn <?=$page == 'results' ? 'selected': ''?>"><i class="fa fa-fw fa-bar-chart"></i></a>
    </footer>

  </body>
</html>
