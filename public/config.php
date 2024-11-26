<?php 
//navn, og antall rom
define("MOTEL_NAME", "Motel California");
define("number_of_rooms", 25);

//absolutt path for load og save_data funksjonene
define("BASE_PATH", dirname(__DIR__));
define("DATA_PATH", BASE_PATH . "/private/data");
//kaller på session
session_start();

//konstant for romtyper
define("ROOM_TYPE",
[
"single" => ["name" => "single_room", "capacity" => ["adults" => 1, "children" => 1]],
"double" => ["name" => "double_room", "capacity" => ["adults" => 2, "children" => 1]],
"family" => ["name" => "family_room", "capacity" => ["adults" => 2, "children" => 3]] 
]);

//konstant for rombeskrivelse
define("ROOM_DESCRIPTIONS",
[
    "single" => "A cozy room suitable for one adult and one child.",
    "double" => "A spacious room ideal for two adults and one child.",
    "family" => "A large room designed for two adults and up to three children."
]);

?>