<?php
  ob_start();
  require 'lib/models.php';

  global $page, $event, $projects, $person, $error, $saved;
  $page = 'vote';
  $event = getCurrentEvent();
  $event_id = is_array($event) ? $event['id'] : NULL;
  $projects = getProjects($event_id);
  $person = getPerson($event_id);
  $error = NULL;
  $saved = is_numeric($person['id']);

  require 'lib/page.php';
  ob_flush();
?>
