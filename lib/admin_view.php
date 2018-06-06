<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <?php if (is_array($_APP['event'])): ?>
        <h1>Administration</h1>
        <form action="/admin_submit.php">
          <input type="hidden" name="id" value="<?=$_APP['event']['id']?>" />
          <?php if ($_APP['saved']): ?>
            <p class="text-success text-center lead"><i class="fa fa-fw fa-check"></i> Active event saved</p>
            <p class="lead filled-form">
              Event: <strong><?=$_APP['event']['name']?></strong><br/>
              Date: <strong><?=$_APP['event']['date']?></strong><br/>
              <?php if (count($_APP['projects']) > 0): ?>
                Projects:<br/>
                <?php foreach ($_APP['projects'] as $project): ?>
                  <?php $votes = $project['vote1'] + $project['vote2'] + $project['vote3']; ?>
                  <i class="fa fa-fw fa-circle-o"></i> <?=$project['name']?>
                  &nbsp;
                  <small class="text-muted"><?=$votes?> vote(s)</small>
                  </br>
                <?php endforeach; ?>
              <?php else: ?>
                No projects yet.
              <?php endif; ?>
            </p>
          <?php endif; ?>

          <?php $er = is_array($_APP['error']) && array_key_exists('name', $_APP['error']) ? $_APP['error']['name'] : NULL; ?>
          <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
            <label class="control-label">Event name</label>
            <input class="form-control" type="text" name="name" value="<?=$_APP['event']['name']?>" />
            <?php if ($er != NULL): ?>
              <div class="help-block"><?=$er?></div>
            <?php endif; ?>
          </div>

          <?php $er = is_array($_APP['error']) && array_key_exists('date', $_APP['error']) ? $_APP['error']['date'] : NULL; ?>
          <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
            <label class="control-label">Event date</label>
            <input class="form-control" type="text" name="date" value="<?=$_APP['event']['date']?>" />
            <?php if ($er != NULL): ?>
              <div class="help-block"><?=$er?></div>
            <?php endif; ?>
          </div>

          <br/>
          <?php if ($_APP['saved'] === TRUE): ?>
            <a href="#" class="btn btn-primary btn-lg modify-event">Modify event</a>
            <a href="/admin_projects.php" class="btn btn-default btn-lg manage-projects">Manage projects</a>
            <button class="btn btn-primary btn-lg" type="submit" style="display: none;">Submit</button>
            <a href="/admin.php" class="btn btn-default btn-lg cancel" style="display: none;">Cancel</a>
          <?php elseif (is_array($_APP['error']) && count($_APP['error']) > 0): ?>
            <p class="text-danger text-center lead"><i class="fa fa-fw fa-warning"></i> Fix 'em errors and try again.</p>
            <button class="btn btn-primary btn-lg" type="submit">Submit again</button>
            <a href="/admin.php" class="btn btn-default btn-lg cancel">Cancel</a>
          <?php else: ?>
            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            <a href="/admin.php" class="btn btn-default btn-lg cancel">Cancel</a>
          <?php endif; ?>

        </form>
      <?php else: ?>
        <p class="lead text-error">No active event!</p>
      <?php endif; ?>
    </div>
  </div>
</div>