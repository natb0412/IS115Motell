<?php 


define("Motel_name", "Motel California");
define("number_of_rooms", 25);


define("room_type",
[
"single" => ["name" => "single_room", "capacity" => ["adults" => 1, "children" => 1]],
"double" => ["name" => "double_room", "capacity" => ["adults" => 2, "children" => 1]],
"family" => ["name" => "family_room", "capacity" => ["adults" => 2, "children" => 3]] 
])

session_start();