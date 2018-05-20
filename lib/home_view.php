<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="splash"><img src="/img/trophy-circle.png" alt="trophy" /></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h1><?=is_array($event) ? $event['name'] : 'No active event exists!'?></h1>
      <h2></h2>
      <br/>
      <p><a href="vote.php" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-check-square-o"></i> Cast your vote</a></p>
    </div>
  </div>
</div>