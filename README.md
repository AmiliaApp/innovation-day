# Innovation Day Voting App
https://amilia.app

# Database
Create a database called 'innovation' with 2 tables `project` and `person_votes`;
```
CREATE TABLE `project` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `project` ADD PRIMARY KEY (`id`);
ALTER TABLE `project` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `person_votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `vote1_project_id` int(10) UNSIGNED DEFAULT NULL,
  `vote2_project_id` int(10) UNSIGNED DEFAULT NULL,
  `vote3_project_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `person_votes` ADD PRIMARY KEY (`id`);
ALTER TABLE `person_votes` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
```

# Configuration
File `lib/config.php` is necessary to set up database credentials.
Therefore, that file is ignored in git. You must create it. On your local environment, would look like this
```
<?php
  define('DB_HOST', '127.0.0.1');
  define('DB_NAME', 'innovation');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
?>
```