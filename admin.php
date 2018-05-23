<?php
  ob_start();
  require 'lib/models.php';

  global $page, $event, $projects, $person, $error, $saved;
  $page = 'admin';
  $event = getCurrentEvent();
  $event_id = is_array($event) ? $event['id'] : NULL;
  $projects = getProjects($event_id);
  $person = NULL;
  $error = NULL;
  $saved = is_numeric($event_id);

  require 'lib/page.php';
  ob_flush();
?>
