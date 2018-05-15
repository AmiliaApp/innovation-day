<?php
  ob_start();
  require 'lib/models.php';

  global $page, $projects, $person, $error, $saved;
  $page = 'results';
  $projects = getProjects();
  $person = getPerson();
  $error = NULL;
  $saved = FALSE;

  require 'lib/page.php';
  ob_flush();
?>
