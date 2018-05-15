<?php
  require 'config.php';
  define('COOKIE_NAME', 'InnovationDay');
  define('TITLE', 'MAY 17 2018 EDITION');
  define('VOTE1_NAME', 'Best overall');
  define('VOTE2_NAME', 'Best presentation');
  define('VOTE3_NAME', 'Best MVP');

  function get($query) {
    $records = getMany($query);
    return count($records) > 0 ? $records[0] : NULL;
  }

  function getMany($query) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

    $records = array();
    if ($result = $mysqli->query($query)) {
      while ($row = $result->fetch_assoc()) $records[] = $row;
      $result->free();
    }

    $mysqli->close();

    return $records;
  }

  function update($query) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);
    $result = $mysqli->query($query);
    $mysqli->close();
    return $result;
  }

  function insert($query) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);
    if ($result = $mysqli->query($query)) {
      $result = $mysqli->insert_id;
    }

    $mysqli->close();
    return $result;
  }

  function getProjects() {
    $projects = getMany("SELECT * FROM project");
    $map = array();
    foreach ($projects as $row => $project) {
      $project_id = (int)$project['id'];
      $projects[$row]['id'] = $project_id;
      $projects[$row]['vote1'] = 0;
      $projects[$row]['vote2'] = 0;
      $projects[$row]['vote3'] = 0;
      $map[$project_id] = $row;
    }
    $votes = getMany("SELECT * FROM person_votes");
    foreach ($votes as $vote) {
      $projects[$map[(int)$vote['vote1_project_id']]]['vote1'] += 1;
      $projects[$map[(int)$vote['vote2_project_id']]]['vote2'] += 1;
      $projects[$map[(int)$vote['vote3_project_id']]]['vote3'] += 1;
    }
    return $projects;
  }

  function getPerson() {
    $person = NULL;
    $id = NULL;
    if (array_key_exists(COOKIE_NAME, $_COOKIE)) $id = $_COOKIE[COOKIE_NAME];
    if (is_numeric($id)) $person = get("SELECT * FROM person_votes WHERE id = $id");
    if ($person == NULL) return array(
      'id' => NULL,
      'date' => NULL,
      'name' => '',
      'vote1_project_id' => NULL,
      'vote2_project_id' => NULL,
      'vote3_project_id' => NULL
    );
    return $person;
  }

  function setPerson($person) {
    $id = $person['id'];

    if (is_numeric($id)) {
      // Update existing record
      $existing = get("SELECT * FROM person_votes WHERE id = $id");
      if ($existing != NULL) {
        $sql = "UPDATE person_votes SET ";
        $sql .= "name='".$person['name']."', ";
        $sql .= "date=NOW(), ";
        $sql .= "vote1_project_id=".$person['vote1_project_id'].", ";
        $sql .= "vote2_project_id=".$person['vote2_project_id'].", ";
        $sql .= "vote3_project_id=".$person['vote3_project_id']." ";
        $sql .= "WHERE id=$id";
        update($sql);
      }
    } else {
      // Insert new record
      $sql = "INSERT INTO person_votes (name, date, vote1_project_id, vote2_project_id, vote3_project_id) VALUES (";
      $sql .= "'".$person['name']."', ";
      $sql .= "NOW(), ";
      $sql .= $person['vote1_project_id'].", ";
      $sql .= $person['vote2_project_id'].", ";
      $sql .= $person['vote3_project_id'].")";
      $id = insert($sql);
      $person['id'] = $id;
    }

    $expire = time()+60*60*24*30;
    setcookie(COOKIE_NAME, $id, $expire, '/');

    return $person;
  }

?>