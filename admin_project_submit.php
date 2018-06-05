<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'admin_projects';
  $_APP['event'] = getCurrentEvent();
  if (!is_array($_APP['event'])) die('No current event exists');


  // Fetch submitted values and update in Database
  $_APP['project'] = array(
    'id' => array_key_exists('id', $_GET) ? $_GET['id'] : NULL,
    'name' => array_key_exists('name', $_GET) ? $_GET['name'] : NULL
  );
  $isNew = $_APP['project']['id'] == NULL;

  // Validation
  $_APP['error'] = array();
  if (empty($_APP['project']['name'])) $_APP['error']['name'] = "Please specify a project name!";

  // Insert or update
  if (empty($_APP['error'])) {
    setProject($_APP['project']);
    if ($isNew) {
      header('Location: /admin_projects.php'); 
      ob_flush();
      exit();
    }
    $_APP['saved'] = TRUE;
  }

  $_APP['projects'] = getProjects($_APP['event']['id']);

  require 'lib/page.php';
  ob_flush();
?>