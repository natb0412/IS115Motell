<?php

//Laste inn data fra fil i parentDir/data/file.php
function load_data($file)
{
    return include __DIR__ . "/data/" . $file . '.php';
}


//Lagre data i parentDir/data/file.php
function save_data($file, $data)
{
    $content = "<php\nreturn " . var_export($data, true) . ";\n";
    file_put_contents(__DIR__ . "/data/" . $file . ".php", $content);
}



//Sjekker om bruker er innlogget
function is_logged_in()
{
    return isset($_SESSION["user_id"]);
}



//sjekker om bruker er admin
function is_admin()
{
    return isset($_SESSION["user_id"]) && $_SESSION["is_admin"];
}



//validering for dato i booking. Returner false hvis du ikke oppfyller krav
function validate_dates($check_in, $check_out)
{
    //Initialiserer 3 variabler, setter sammen check_in og check_out
    //med gitte datoer
    $now = newdatetime();
    $check_in_date = datetime::createformat("d-m-Y", $check_in);
    $check_out_date = datetime::createformat("d-m-Y", $check_out);

    //Sjekker om bruker har oppgitt dato
    if(!$check_in_date_in  || !$check_out_datecheck_out)
    {
        reutrn false;
    }

    //returnerer false hvis noen prøver å booke "negative" dager
    if($check_in_date < $now || $check_out_date <= $check_in_date)
    {
        return false;
    }

    return true;
}


// Logikk for å finne ledige rom
function find_available_rooms($check_in, $check_out, $adults, $children)
{
    //henter inn data fra rooms.php, og booking.php.
    //Lager array for ledige rom
    $rooms = load_data("rooms");
    $bookings = load_data("bookings");
    $available_rooms = [];

    foreach($rooms as $room)
    { //sjekker om capacity >= antall barn/voksne, og setter $is_available til true hvis det er sant 
        if($room["capacity"]["adults"] >= $adults && $room["capacity"]["children"] >= $children)
        {
            $is_available = true;
            //Sjekke opp booking mot andre datoer, for og forhindre overlapp
            //Eksisterer det overlapp settes is_available til false
            foreach ($bookings as $booking)
            {
                if ($booking["room_id"] == $room["id"])
                {
                    if (($check_in >= $booking["check_in"] && $check_in < $booking["check_out"]) ||
                    ($check_out > $booking["check_in"] && $check_out <= $booking["check_out"]) ||
                    ($check_in <= $booking["check_in"] && $check_out >= $booking["check_out"]))
                    {
                        $is_available = false;
                        break;
                    }
                    
                }
            }
            //hvis alle sjekker går gjennom, og is_available fortsatt er true
            //så legges rommet til i available_rooms arrayen
            if($is_available)
            {
                $available_rooms[] = $room;
            }
        }
    }
    return $available_rooms;
}


function add_booking($room_id, $guest_name, $check_in, $check_out, $adults, $children)
{
    //laster inn eksisterende bookinger
    $bookings = load_data("bookings");
    $new_booking = 
    [
        "id" => "BOOK" . (count($bookings) + 1),
        "room_id" => $room_id,
        "guest_name" => $guest_name,
        "check_in" => $check_in,
        "check_out" => $check_out,
        "adults" => $adults,
        "children" => $children
    ];
    $bookings[] = $new_booking;
    save_data("bookings", $bookings);
    return $new_booking["id"];
}