<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <?php if (is_array($event)): ?>
        <h1>Active Event</h1>
        <form action="/admin_submit.php">
          <input type="hidden" name="id" value="<?=$event['id']?>" />
          <?php if ($saved): ?>
            <p class="text-success text-center lead"><i class="fa fa-fw fa-check"></i> Active event saved</p>
          <?php endif; ?>

          <?php $er = is_array($error) && array_key_exists('name', $error) ? $error['name'] : NULL; ?>
          <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
            <label class="control-label">Event name</label>
            <input class="form-control" type="text" name="name" value="<?=$event['name']?>" />
            <?php if ($er != NULL): ?>
              <div class="help-block"><?=$er?></div>
            <?php endif; ?>
          </div>

          <?php $er = is_array($error) && array_key_exists('date', $error) ? $error['date'] : NULL; ?>
          <div class="form-group form-group-lg <?=$er != NULL ? 'has-error' : ''?>">
            <label class="control-label">Event date</label>
            <input class="form-control" type="text" name="date" value="<?=$event['date']?>" />
            <?php if ($er != NULL): ?>
              <div class="help-block"><?=$er?></div>
            <?php endif; ?>
          </div>

        <br/>
        <?php if (is_array($error) && count($error) > 0): ?>
          <p class="text-danger text-center lead"><i class="fa fa-fw fa-warning"></i> Fix 'em errors and try again.</p>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit again</button>
        <?php else: ?>
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
        <?php endif; ?>

        </form>
      <?php else: ?>
        <p class="lead text-error">No active event!</p>
      <?php endif; ?>
    </div>
  </div>
</div>