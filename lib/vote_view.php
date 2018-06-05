<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <form action="/vote_submit.php">
        <input type="hidden" name="id" value="<?=$_APP['person']['id']?>" />
        <?php if ($_APP['saved']): ?>
          <p class="text-success text-center lead"><i class="fa fa-fw fa-check"></i> Your vote was saved!</p>
          <p class="lead filled-form">
            <?php
              $vote1_project_name = ''; $vote2_project_name = ''; $vote3_project_name = '';
              foreach ($_APP['projects'] as $project) {
                if ($project['id'] == $_APP['person']['vote1_project_id']) $vote1_project_name = $project['name'];
                if ($project['id'] == $_APP['person']['vote2_project_id']) $vote2_project_name = $project['name'];
                if ($project['id'] == $_APP['person']['vote3_project_id']) $vote3_project_name = $project['name'];
              }
            ?>
            Your name: <strong><?=$_APP['person']['name']?></strong><br/>
            <i class="fa fa-fw fa-trophy"></i> Best overall: <strong><?=$vote1_project_name?></strong><br/>
            <i class="fa fa-fw fa-smile-o"></i> Best presentation: <strong><?=$vote2_project_name?></strong><br/>
            <i class="fa fa-fw fa-smile-o"></i> Best MVP: <strong><?=$vote3_project_name?></strong><br/>
          </p>
        <?php endif; ?>

        <?php $error = is_array($_APP['error']) && array_key_exists('name', $_APP['error']) ? $_APP['error']['name'] : NULL; ?>
        <div class="form-group form-group-lg <?=$error != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
          <label class="control-label">Your name</label>
          <input class="form-control" type="text" name="name" value="<?=$_APP['person']['name']?>" />
          <?php if ($error != NULL): ?>
            <div class="help-block"><?=$error?></div>
          <?php endif; ?>
        </div>

        <?php $error = is_array($_APP['error']) && array_key_exists('vote1_project_id', $_APP['error']) ? $_APP['error']['vote1_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$error != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best overall</label>
          <select class="form-control" name="vote1_project_id">
            <?php foreach ($_APP['projects'] as $project): ?>
              <option value="<?=$project['id']?>" <?=$project['id'] == $_APP['person']['vote1_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
            <?php endforeach; ?>>
          </select>
          <?php if ($error != NULL): ?>
            <div class="help-block"><?=$error?></div>
          <?php endif; ?>
        </div>

        <?php $error = is_array($_APP['error']) && array_key_exists('vote2_project_id', $_APP['error']) ? $_APP['error']['vote2_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$error != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best presentation</label>
          <select class="form-control" name="vote2_project_id">
            <?php foreach ($_APP['projects'] as $project): ?>
              <option value="<?=$project['id']?>" <?=$project['id'] == $_APP['person']['vote2_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
            <?php endforeach; ?>>
          </select>
          <?php if ($error != NULL): ?>
            <div class="help-block"><?=$error?></div>
          <?php endif; ?>
        </div>

        <?php $error = is_array($_APP['error']) && array_key_exists('vote3_project_id', $_APP['error']) ? $_APP['error']['vote3_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$error != NULL ? 'has-error' : ''?>" <?=$_APP['saved'] ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best MVP</label>
          <select class="form-control" name="vote3_project_id">
            <?php foreach ($_APP['projects'] as $project): ?>
              <option value="<?=$project['id']?>" <?=$project['id'] == $_APP['person']['vote3_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
            <?php endforeach; ?>>
          </select>
          <?php if ($error != NULL): ?>
            <div class="help-block"><?=$error?></div>
          <?php endif; ?>
        </div>

        <br/>
        <?php if ($_APP['saved'] === TRUE): ?>
          <a class="btn btn-success btn-lg btn-block" href="/results.php">Go see results</a>
          <a class="btn btn-default btn-block submit-again" href="#">Vote again</a>
          <button class="btn btn-primary btn-lg btn-block" type="submit" style="display: none;">Submit</button>
        <?php elseif (is_array($_APP['error']) && count($_APP['error']) > 0): ?>
          <p class="text-danger text-center lead"><i class="fa fa-fw fa-warning"></i> Fix 'em errors and try again.</p>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit again</button>
        <?php else: ?>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>