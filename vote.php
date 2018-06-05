<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'vote';
  $_APP['event'] = getCurrentEvent();
  $event_id = is_array($_APP['event']) ? $_APP['event']['id'] : NULL;
  $_APP['projects'] = getProjects($event_id);
  $_APP['person'] = getPerson($event_id);
  $_APP['saved'] = is_numeric($_APP['person']['id']);

  require 'lib/page.php';
  ob_flush();
?>
