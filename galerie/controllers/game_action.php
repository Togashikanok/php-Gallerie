<?php
 $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
 if ($id===null || $id === false || !file_exists("models/game_$id.php")) {
   throw new Exception();
 }
include 'models/team_names.php';
include "models/game_$id.php";
$title= $team_names[$game['teams'][0]]."-".$team_names[$game['teams'][1]];
$view ="game";
include 'views/page.php';
