<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'admin';

  // Fetch submitted values and update in Database
  $_APP['event'] = array(
    'id' => array_key_exists('id', $_GET) ? $_GET['id'] : NULL,
    'name' => array_key_exists('name', $_GET) ? $_GET['name'] : NULL,
    'date' => array_key_exists('date', $_GET) ? $_GET['date'] : NULL
  );

  // Validation
  $_APP['error'] = array();
  if (empty($_APP['event']['name'])) $_APP['error']['name'] = "Please specify an event name!";
  if (empty($_APP['event']['date'])) {
    $_APP['error']['date'] = "Please specify an event date!";
  } else {
    $d = DateTime::createFromFormat('Y-m-d', $_APP['event']['date']);
    if (!$d || $d->format('Y-m-d') != $_APP['event']['date'])
      $_APP['error']['date'] = "Invalid date. Must be Y-m-d. For example 2017-05-17.";
  }

  // Insert or update
  if (empty($_APP['error'])) {
    setCurrentEvent($_APP['event']);
    $_APP['saved'] = TRUE;
  }

  $event_id = is_array($_APP['event']) ? $_APP['event']['id'] : NULL;
  $_APP['projects'] = getProjects($event_id);

  require 'lib/page.php';
  ob_flush();
?>