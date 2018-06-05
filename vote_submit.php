<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'vote';
  $_APP['event'] = getCurrentEvent();
  $event_id = is_array($_APP['event']) ? $_APP['event']['id'] : NULL;
  $_APP['projects'] = getProjects($event_id);

  // Fetch submitted values and update in Database
  $_APP['person'] = array(
    'id' => array_key_exists('id', $_GET) ? $_GET['id'] : NULL,
    'name' => array_key_exists('name', $_GET) ? $_GET['name'] : NULL,
    'vote1_project_id' => array_key_exists('vote1_project_id', $_GET) ? $_GET['vote1_project_id'] : NULL,
    'vote2_project_id' => array_key_exists('vote2_project_id', $_GET) ? $_GET['vote2_project_id'] : NULL,
    'vote3_project_id' => array_key_exists('vote3_project_id', $_GET) ? $_GET['vote3_project_id'] : NULL
  );

  // Validation
  $_APP['error'] = array();
  if (empty($_APP['person']['name'])) $_APP['error']['name'] = "You forgot to tell me your name!";

  $project_ids = array();
  foreach ($_APP['projects'] as $project) $project_ids[] = $project['id'];
  if (!in_array($_APP['person']['vote1_project_id'], $project_ids))
    $_APP['error']['vote1_project_id'] = "Invalid project id (".$_APP['person']['vote1_project_id'].") for ".VOTE1_NAME;
  if (!in_array($_APP['person']['vote1_project_id'], $project_ids))
    $_APP['error']['vote2_project_id'] = "Invalid project id (".$_APP['person']['vote2_project_id'].") for ".VOTE2_NAME;
  if (!in_array($_APP['person']['vote1_project_id'], $project_ids))
    $_APP['error']['vote3_project_id'] = "Invalid project id (".$_APP['person']['vote3_project_id'].") for ".VOTE3_NAME;

  // Insert or update. Will persist session in a cookie. Returns the update/inserted person.
  if (empty($_APP['error'])) {
    $_APP['person']['session'] = setPerson($_APP['person']);
    $_APP['saved'] = TRUE;
  }

  require 'lib/page.php';
  ob_flush();
?>