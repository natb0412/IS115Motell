<?php 
define("MOTEL_NAME", "Motel California");
define("number_of_rooms", 25);

define("BASE_PATH", dirname(__DIR__));
define("DATA_PATH", BASE_PATH . "/private/data");
session_start();

define("room_type",
[
"single" => ["name" => "single_room", "capacity" => ["adults" => 1, "children" => 1]],
"double" => ["name" => "double_room", "capacity" => ["adults" => 2, "children" => 1]],
"family" => ["name" => "family_room", "capacity" => ["adults" => 2, "children" => 3]] 
]);


?>