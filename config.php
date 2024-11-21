<?php 


define("Motell_navn", "Motel California");
define("Antall_rom", 25);


define("Rom_typer",
[
"enkelt" => ["navn" => "Enkeltrom", "kapasitet" => ["voksne" => 1, "barn" => 1]],
"dobbelt" => ["navn" => "Dobbeltrom", "kapasitet" => ["voksne" => 2, "barn" => 1]],
"Familierom" => ["navn" => "Familierom", "kapasitet" => ["voksne" => 2, "barn" => 3]] 
])

session_start();