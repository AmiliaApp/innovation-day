<?php
  require 'config.php';
  define('VOTE1_NAME', 'Best overall');
  define('VOTE2_NAME', 'Best presentation');
  define('VOTE3_NAME', 'Best MVP');

  global $_APP;
  $_APP = array(
    'page' => 'home',
    'event' => NULL,
    'projects' => array(),
    'project' => NULL,
    'person' => NULL,
    'error' => NULL,
    'saved' => FALSE
  );

  /* Admin authentication */
  function isAdminAuthenticated() {
    return array_key_exists(ADMIN_COOKIE_NAME, $_COOKIE)) && $_COOKIE[ADMIN_COOKIE_NAME] == ADMIN_COOKIE_SECRET_VALUE;
  }

  function authenicateAdmin($password) {
    if ($password == ADMIN_PASSWORD) {
        $expire = time()+60*60*24*30;
        setcookie(ADMIN_COOKIE_NAME, ADMIN_COOKIE_SECRET_VALUE, $expire, '/');
      return TRUE;
    }
    return FALSE;
  }

  /*
    Events - a list of innovation day events.
    table: event
    Only one current model can exist. This implies column 'active' is set to 1 on only one event.
    Methods here act on the current active model only.
  */

  function getCurrentEvent() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $result = $mysqli->query("SELECT * FROM event WHERE active=1");
    $event = $result->fetch_assoc();
    $result->free();

    $mysqli->close();

    return $event;
  }

  function setCurrentEvent($event) {
    if (!empty($event['id'])) {
      $current = getCurrentEvent();
      if ($event['id'] != $current['id']) die("Event id is not the current event.");
    }

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    if (!empty($event['id'])) {
      // Update
      $stmt = $mysqli->prepare("UPDATE event SET name=?, date=? WHERE id=?");
      $stmt->bind_param("ssi", $name, $date, $event_id);
      $name = $event['name'];
      $date = $event['date'];
      $event_id = $event['id'];
      $stmt->execute();
      $stmt->close();
    } else {
      // Insert
      $stmt = $mysqli->prepare("INSERT INTO event (name, date, active) VALUES (?, ?, ?)");
      $stmt->bind_param("ss", $name, $date, $active);
      $name = $event['name'];
      $date = $event['date'];
      $active = 1;
      $stmt->execute();
      $stmt->close();

      $event['id'] = $mysqli->insert_id;
      $event_id = $event['id'];
      $mysqli->query("UPDATE event SET active=0 WHERE id != $event_id AND active = 1");
    }

    $mysqli->close();

    return $event;
  }

  /*
    Projects - a list of projects per innovation day event
    table: project
  */
  function getProjects($event_id) {
    if (!is_numeric($event_id)) return array();

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $projects = array();
    $map = array();
    if ($result = $mysqli->query("SELECT * FROM project WHERE event_id=$event_id ORDER BY id DESC")) {
      while ($project = $result->fetch_assoc()) {
        $project_id = (int)$project['id'];
        $project['id'] = $project_id;
        $project['vote1'] = 0;
        $project['vote2'] = 0;
        $project['vote3'] = 0;
        $map[$project_id] = count($projects);
        $projects[] = $project;
      }
      $result->free();
    }

    if ($result = $mysqli->query("SELECT * FROM person_votes WHERE event_id=$event_id")) {
      while ($vote = $result->fetch_assoc()) {
        $projects[$map[(int)$vote['vote1_project_id']]]['vote1'] += 1;
        $projects[$map[(int)$vote['vote2_project_id']]]['vote2'] += 1;
        $projects[$map[(int)$vote['vote3_project_id']]]['vote3'] += 1;
      }
      $result->free();
    }

    $mysqli->close();
    return $projects;
  }

  function getProject($project_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $stmt = $mysqli->prepare("SELECT * FROM project WHERE id=?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
    $result->free();
    $stmt->close();

    if (is_array($project)) {
      $project['vote1'] = 0;
      $project['vote2'] = 0;
      $project['vote3'] = 0;

      $stmt = $mysqli->prepare("SELECT * FROM person_votes WHERE vote1_project_id=? || vote2_project_id=? || vote3_project_id=?");
      $stmt->bind_param("iii", $project_id, $project_id, $project_id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($vote = $result->fetch_assoc()) {
        $project['vote1'] += (int)$vote['vote1_project_id'];
        $project['vote2'] += (int)$vote['vote2_project_id'];
        $project['vote3'] += (int)$vote['vote3_project_id'];
      }
      $result->free();
      $stmt->close();
    }

    $mysqli->close();

    return is_array($project) ? $project : NULL;
  }

  function setProject($project) {
    $event = getCurrentEvent();
    if (!is_array($event)) die("No current event.");

    if (!empty($project['id'])) {
      $existing = getProject($project['id']);
      if ($project['id'] != $existing['id']) die("Project id ".$project['id']."does not exist.");
    }

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    if (!empty($project['id'])) {
      // Update
      $stmt = $mysqli->prepare("UPDATE project SET name=? WHERE id=?");
      $stmt->bind_param("si", $name, $project_id);
      $name = $project['name'];
      $project_id = $project['id'];
      $stmt->execute();
      $stmt->close();
    } else {
      // Insert
      $stmt = $mysqli->prepare("INSERT INTO project (name, event_id, date) VALUES (?, ?, ?)");
      $stmt->bind_param("sis", $name, $event_id, $date);
      $name = $project['name'];
      $date = $event['date'];
      $event_id = $event['id'];
      $stmt->execute();
      $stmt->close();
      $project['id'] = $mysqli->insert_id;
    }

    $mysqli->close();

    return $project;
  }

  function deleteProject($project_id) {
    $event = getCurrentEvent();
    if (!is_array($event)) return FALSE;

    $project = getProject($project_id);
    if (!is_array($project)) return FALSE;
    if ($project['event_id'] != $event['id']) return FALSE;
    if ($project['vote1'] + $project['vote2'] + $project['vote3'] > 0) return FALSE;

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $stmt = $mysqli->prepare("DELETE FROM project WHERE id=?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $stmt->close();

    $mysqli->close();

    return TRUE;
  }

  /*
    Votes - a list of person-votes per innovation day event
    table: person_votes
  */
  function getPerson($event_id) {
    $empty = array(
      'id' => NULL,
      'session' => NULL,
      'date' => NULL,
      'name' => '',
      'vote1_project_id' => NULL,
      'vote2_project_id' => NULL,
      'vote3_project_id' => NULL
    );
    if (!is_numeric($event_id)) return $empty;

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $cookie_name = COOKIE_NAME . $event_id;

    $person = NULL;
    if (array_key_exists($cookie_name, $_COOKIE)) {
      $stmt = $mysqli->prepare("SELECT * FROM person_votes WHERE session=?");
      $stmt->bind_param("s", $_COOKIE[$cookie_name]);
      $stmt->execute();
      $result = $stmt->get_result();
      $person = $result->fetch_assoc();
      $result->free();
      $stmt->close();
    }

    $mysqli->close();

    return is_array($person) ? $person : $empty;
  }

  function setPerson($person) {
    $event = getCurrentEvent();
    if (!is_array($event)) die("No active event");

    $session = NULL;
    $existing = getPerson($event['id']);

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    if ($existing['session'] != NULL) {
      // Update
      $stmt = $mysqli->prepare("UPDATE person_votes SET event_id=?, name=?, date=?, vote1_project_id=?, vote2_project_id=?, vote3_project_id=? WHERE session=?");
      $stmt->bind_param("issiiis", $event_id, $name, $date, $vote1_project_id, $vote2_project_id, $vote3_project_id, $session);
      $session = $existing['session'];
      $event_id = $event['id'];
      $name = $person['name'];
      $date = date('Y-m-d', time());
      $vote1_project_id = $person['vote1_project_id'];
      $vote2_project_id = $person['vote2_project_id'];
      $vote3_project_id = $person['vote3_project_id'];
      $stmt->execute();
      $stmt->close();
    } else {
      // Insert
      $stmt = $mysqli->prepare("INSERT INTO person_votes (event_id, session, name, date, vote1_project_id, vote2_project_id, vote3_project_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssiii", $event_id, $session, $name, $date, $vote1_project_id, $vote2_project_id, $vote3_project_id);
      $session = md5(time().$person['name'].'salty-chips');
      $event_id = $event['id'];
      $name = $person['name'];
      $date = date('Y-m-d', time());
      $vote1_project_id = $person['vote1_project_id'];
      $vote2_project_id = $person['vote2_project_id'];
      $vote3_project_id = $person['vote3_project_id'];
      $stmt->execute();
      $stmt->close();
    }

    $mysqli->close();

    $cookie_name = COOKIE_NAME . $event['id'];
    $expire = time()+60*60*24*30;
    setcookie($cookie_name, $session, $expire, '/');

    return $session;
  }

?>