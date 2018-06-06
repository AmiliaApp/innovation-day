<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'admin_projects';
  $_APP['event'] = getCurrentEvent();
  if (!is_array($_APP['event'])) die('No current event exists');

  die('Not yet implemented');

  $_APP['projects'] = getProjects($_APP['event']['id']);

  require 'lib/page.php';
  ob_flush();
?>