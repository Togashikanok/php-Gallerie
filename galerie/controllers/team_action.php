<?php
 $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
 if ($id===null || $id === false || !file_exists("models/team_$id.php")) {
   throw new Exception();
 }
include 'models/team_names.php';
include "models/team_$id.php";
$title=$team_names[$id];
$view ="team";
include 'views/page.php';
