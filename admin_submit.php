<?php
  ob_start();
  require 'lib/models.php';

  global $page, $event, $projects, $person, $error, $saved;
  $page = 'admin';
  $person = NULL;
  $saved = FALSE;

  // Fetch submitted values and update in Database
  $event = array(
    'id' => array_key_exists('id', $_GET) ? $_GET['id'] : NULL,
    'name' => array_key_exists('name', $_GET) ? $_GET['name'] : NULL,
    'date' => array_key_exists('date', $_GET) ? $_GET['date'] : NULL
  );

  // Validation
  $error = array();
  if (empty($event['name'])) $error['name'] = "Please specify an event name!";
  if (empty($event['date'])) {
    $error['date'] = "Please specify an event date!";
  } else {
    $d = DateTime::createFromFormat('Y-m-d', $event['date']);
    if (!$d || $d->format('Y-m-d') != $event['date'])
      $error['date'] = "Invalid date. Must be Y-m-d. For example 2017-05-17.";
  }

  // Insert or update
  if (empty($error)) {
    setCurrentEvent($event);
    $saved = TRUE;
  }

  $event_id = is_array($event) ? $event['id'] : NULL;
  $projects = getProjects($event_id);

  require 'lib/page.php';
  ob_flush();
?>