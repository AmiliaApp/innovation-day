<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <form action="/submit.php">
        <input type="hidden" name="id" value="<?=$person['id']?>" />
        <?php if ($saved): ?>
          <p class="text-success text-center lead"><i class="fa fa-fw fa-check"></i> Your vote was saved!</p>
          <p class="lead filled-form">
            <?php
              $vote1_project_name = ''; $vote2_project_name = ''; $vote3_project_name = '';
              foreach ($projects as $project) {
                if ($project['id'] == $person['vote1_project_id']) $vote1_project_name = $project['name'];
                if ($project['id'] == $person['vote2_project_id']) $vote2_project_name = $project['name'];
                if ($project['id'] == $person['vote3_project_id']) $vote3_project_name = $project['name'];
              }
            ?>
            Your name: <strong><?=$person['name']?></strong><br/>
            <i class="fa fa-fw fa-trophy"></i> Best overall: <strong><?=$vote1_project_name?></strong><br/>
            <i class="fa fa-fw fa-smile-o"></i> Best presentation: <strong><?=$vote2_project_name?></strong><br/>
            <i class="fa fa-fw fa-smile-o"></i> Best MVP: <strong><?=$vote3_project_name?></strong><br/>
          </p>
        <?php endif; ?>

        <?php $er = is_array($error) && array_key_exists('name', $error) ? $error['name'] : NULL; ?>
        <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$saved ? 'style="display:none;"' : ''?>>
          <label class="control-label">Your name</label>
          <input class="form-control" type="text" name="name" value="<?=$person['name']?>" />
          <?php if ($er != NULL): ?>
            <div class="help-block"><?=$er?></div>
          <?php endif; ?>
        </div>

        <?php $er = is_array($error) && array_key_exists('vote1_project_id', $error) ? $error['vote1_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$saved ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best overall</label>
          <select class="form-control" name="vote1_project_id">
            <?php foreach ($projects as $project): ?>
              <option value="<?=$project['id']?>" <?=$project['id'] == $person['vote1_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
            <?php endforeach; ?>>
          </select>
          <?php if ($er != NULL): ?>
            <div class="help-block"><?=$er?></div>
          <?php endif; ?>
        </div>

        <?php $er = is_array($error) && array_key_exists('vote2_project_id', $error) ? $error['vote2_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$saved ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best presentation</label>
          <select class="form-control" name="vote2_project_id">
            <?php foreach ($projects as $project): ?>
              <option value="<?=$project['id']?>" <?=$project['id'] == $person['vote2_project_id'] ? 'selected="selected"' : ''?>><?=$project['name']?></option>
            <?php endforeach; ?>>
          </select>
          <?php if ($er != NULL): ?>
            <div class="help-block"><?=$er?></div>
          <?php endif; ?>
        </div>

        <?php $er = is_array($error) && array_key_exists('vote3_project_id', $error) ? $error['vote3_project_id'] : NULL; ?>
        <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>" <?=$saved ? 'style="display:none;"' : ''?>>
          <label class="control-label">Best MVP</label>
          <select class="form-control" name="vote3_project_id">
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
        <?php elseif (is_array($error) && count($error) > 0): ?>
          <p class="text-danger text-center lead"><i class="fa fa-fw fa-warning"></i> Fix 'em errors and try again.</p>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit again</button>
        <?php else: ?>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>