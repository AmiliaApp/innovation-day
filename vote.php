<?php
  ob_start();
  require 'lib/models.php';

  global $page, $projects, $person, $error, $saved;
  $page = 'vote';
  $projects = getProjects();
  $person = getPerson();
  $error = NULL;
  $saved = is_numeric($person['id']);

  require 'lib/page.php';
  ob_flush();
?>
