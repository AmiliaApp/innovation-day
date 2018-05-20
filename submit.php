<?php
  ob_start();
  require 'lib/models.php';

  global $page, $event, $projects, $person, $error, $saved;
  $page = 'vote';
  $event = getCurrentEvent();
  $event_id = is_array($event) ? $event['id'] : NULL;
  $projects = getProjects($event_id);
  $saved = FALSE;

  // Fetch submitted values and update in Database
  $person = array(
    'id' => array_key_exists('id', $_GET) ? $_GET['id'] : NULL,
    'name' => array_key_exists('name', $_GET) ? $_GET['name'] : NULL,
    'vote1_project_id' => array_key_exists('vote1_project_id', $_GET) ? $_GET['vote1_project_id'] : NULL,
    'vote2_project_id' => array_key_exists('vote2_project_id', $_GET) ? $_GET['vote2_project_id'] : NULL,
    'vote3_project_id' => array_key_exists('vote3_project_id', $_GET) ? $_GET['vote3_project_id'] : NULL
  );

  // Validation
  $error = array();
  if (empty($person['name'])) $error['name'] = "You forgot to tell me your name!";

  $project_ids = array();
  foreach ($projects as $project) $project_ids[] = $project['id'];
  if (!in_array($person['vote1_project_id'], $project_ids))
    $error['vote1_project_id'] = "Invalid project id (".$person['vote1_project_id'].") for ".VOTE1_NAME;
  if (!in_array($person['vote1_project_id'], $project_ids))
    $error['vote2_project_id'] = "Invalid project id (".$person['vote2_project_id'].") for ".VOTE2_NAME;
  if (!in_array($person['vote1_project_id'], $project_ids))
    $error['vote3_project_id'] = "Invalid project id (".$person['vote3_project_id'].") for ".VOTE3_NAME;

  // Insert or update. Will persist session in a cookie. Returns the update/inserted person.
  if (empty($error)) {
    $person['session'] = setPerson($person);
    $saved = TRUE;
  }

  require 'lib/page.php';
  ob_flush();
?>