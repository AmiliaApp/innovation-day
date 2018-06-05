<?php
  ob_start();
  require 'lib/models.php';

  $_APP['page'] = 'results';
  $_APP['event'] = getCurrentEvent();
  $event_id = is_array($_APP['event']) ? $_APP['event']['id'] : NULL;
  $_APP['projects'] = getProjects($event_id);
  $_APP['person'] = getPerson($event_id);

  require 'lib/page.php';
  ob_flush();
?>
