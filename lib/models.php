<?php
  require 'config.php';
  define('COOKIE_NAME', 'InnovationDay');
  define('TITLE', 'MAY 17 2018 EDITION');
  define('VOTE1_NAME', 'Best overall');
  define('VOTE2_NAME', 'Best presentation');
  define('VOTE3_NAME', 'Best MVP');

  function getProjects() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $projects = array();
    $map = array();
    if ($result = $mysqli->query("SELECT * FROM project")) {
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

    if ($result = $mysqli->query("SELECT * FROM person_votes")) {
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

  function getPerson() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $person = NULL;
    if (array_key_exists(COOKIE_NAME, $_COOKIE)) {
      $stmt = $mysqli->prepare("SELECT * FROM person_votes WHERE session=?");
      $stmt->bind_param("s", $_COOKIE[COOKIE_NAME]);
      $stmt->execute();
      $result = $stmt->get_result();
      $person = $result->fetch_assoc();
      $result->free();
      $stmt->close();
    }

    $mysqli->close();

    return is_array($person) ? $person : array(
      'id' => NULL,
      'session' => NULL,
      'date' => NULL,
      'name' => '',
      'vote1_project_id' => NULL,
      'vote2_project_id' => NULL,
      'vote3_project_id' => NULL
    );
  }

  function setPerson($person) {
    $session = NULL;
    $existing = getPerson();

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    if ($existing['session'] != NULL) {
      // Update
      $stmt = $mysqli->prepare("UPDATE person_votes SET name=?, date=?, vote1_project_id=?, vote2_project_id=?, vote3_project_id=? WHERE session=?");
      $stmt->bind_param("ssiiis", $name, $date, $vote1_project_id, $vote2_project_id, $vote3_project_id, $session);
      $session = $existing['session'];
      $name = $person['name'];
      $date = date('Y-m-d', time());
      $vote1_project_id = $person['vote1_project_id'];
      $vote2_project_id = $person['vote2_project_id'];
      $vote3_project_id = $person['vote3_project_id'];
      $stmt->execute();
      $stmt->close();
    } else {
      // Insert
      $stmt = $mysqli->prepare("INSERT INTO person_votes (session, name, date, vote1_project_id, vote2_project_id, vote3_project_id) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssiii", $session, $name, $date, $vote1_project_id, $vote2_project_id, $vote3_project_id);
      $session = md5(time().$person['name'].'salty-chips');
      $name = $person['name'];
      $date = date('Y-m-d', time());
      $vote1_project_id = $person['vote1_project_id'];
      $vote2_project_id = $person['vote2_project_id'];
      $vote3_project_id = $person['vote3_project_id'];
      $stmt->execute();
      $stmt->close();
    }
    
    $mysqli->close();

    $expire = time()+60*60*24*30;
    setcookie(COOKIE_NAME, $session, $expire, '/');

    return $session;
  }

?>