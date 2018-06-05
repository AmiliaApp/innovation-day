<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-3">
      <?php if (!is_array($_APP['event'])): ?>
        <h1>No event defined. Please create an event.</h1>
        <a href="/admin.php" class="btn btn-primary btn-lg btn-block">Create an event</a>
      <?php else: ?>
        <h1>Projects <small><?=$_APP['event']['name']?>, <?=$_APP['event']['date']?></small></h1>
        <br/>
        <p>
          <a href="/admin_project_submit.php?name=New+project" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Project</a>
          <a href="/admin.php" class="btn btn-default btn-lg"><i class="fa fa-fw fa-reply"></i> Back to event</a>
        </p>
        <br/>
        <?php if (count($_APP['projects']) > 0): ?>
          <?php foreach ($_APP['projects'] as $project): ?>
          <?php
            $isActive = isset($_APP['project']) && $_APP['project']['id'] == $project['id'];
            $formGroupState = $isActive ? 'has-success' : '';
          ?>
            <form class="form-horizontal" action="admin_project_submit.php" data-id="<?=$project['id']?>">
              <input type="hidden" name="id" value="<?=$project['id']?>" />
              <div class="form-group form-group-lg <?=$formGroupState?>">
                <div class="col-sm-9">
                  <input class="form-control" type="text" name="name" value="<?=$project['name']?>" />
                  <?php if ($isActive): ?>
                    <span id="helpBlock" class="help-block"><i class="fa fa-fw fa-check"></i> Project saved.</span>
                  <?php endif; ?>
                </div>
                <div class="col-sm-3">
                  <button class="btn btn-default" type="submit">Update</button>
                  <a class="text-danger hidden" href="admin_project_delete.php?id=<?=$project['id']?>"><i class="fa fa-fw fa-trash"></i></a>
                </div>
              </div>
            </form>
            <br/>
          <?php endforeach; ?>
          <br/>
          <p>
            <a href="/admin_project_submit.php?name=New+project" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Project</a>
            <a href="/admin.php" class="btn btn-default btn-lg"><i class="fa fa-fw fa-reply"></i> Back to event</a>
          </p>
        <?php else: ?>
          <p class="lead text-muted text-centered">No projects yet.</p>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</div>