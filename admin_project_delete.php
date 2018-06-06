<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'admin_projects';
  $_APP['event'] = getCurrentEvent();
  if (!is_array($_APP['event'])) die('No current event exists');

  $project_id = array_key_exists('id', $_GET) ? $_GET['id'] : NULL;
  if (!is_numeric($project_id)) die('Project does not exist.');

  $project = getProject($project_id);
  if (!is_array($project) || $project['event_id'] != $_APP['event']['id'])
    die('Project does not exist.');
  if ($project['vote1'] + $project['vote2'] + $project['vote3'] > 0)
    die('Cannot delete a project with votes');

  deleteProject($project_id);

  $_APP['projects'] = getProjects($_APP['event']['id']);

  require 'lib/page.php';
  ob_flush();
?>