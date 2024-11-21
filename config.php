<?php 


define("Motell_navn", "Motel California");
define("Antall_rom", 25);


define("Rom_typer",
[
"enkelt" => ["name" => "Enkeltrom", "capacity" => ["adults" => 1, "children" => 1]],
"dobbelt" => ["name" => "Dobbeltrom", "capacity" => ["adults" => 2, "children" => 1]],
"Familierom" => ["name" => "Familierom", "capacity" => ["adults" => 2, "children" => 3]] 
])

session_start();