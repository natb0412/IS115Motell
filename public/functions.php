<?php

//DATALAGRING OG SENDING

//Laster inn data. Config inneholder koding for BASE og DATA_PATH
function load_data($file)
{
    $filepath = DATA_PATH . "/" . $file . ".php";
    if(file_exists($filepath))
    {
        return include $filepath;
    }
    else
    {
        throw new Exception("File not found: " . $filepath);
    }
}


//Lagre data i parentDir/data/file.php
function save_data($file, $data)
{
    $content = "<?php\nreturn " . var_export($data, true) . ";\n";
    $filepath1 = DATA_PATH . "/" . $file . ".php";
    file_put_contents($filepath1, $content);
    if (file_put_contents($filepath1, $content) === false)
    {
        throw new Exception("Failed to write data to file: " . $filepath1);
    }
}


//SJEKKING AV BRUKER

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

//ALT AV ROMBOOKING

//validering for dato i booking. Returner false hvis du ikke oppfyller krav
function validate_dates($check_in, $check_out)
{
    //Initialiserer 3 variabler, setter sammen check_in og check_out med gitte datoer
    $now = newdatetime();
    $check_in_date = datetime::createformat("d-m-Y", $check_in);
    $check_out_date = datetime::createformat("d-m-Y", $check_out);

    //Sjekker om bruker har oppgitt dato
    if(!$check_in_date_in  || !$check_out_datecheck_out)
    {
        return false;
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
            //Sjekke opp booking mot andre datoer, for å forhindre overlapp
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

    //lager ny booking
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
    //legger til booking i bookings-arrayen, og lagrer deretter dataen i bookings.php
    $bookings[] = $new_booking;
    save_data("bookings", $bookings);
    return $new_booking["id"];
}


//ADMINFUNKSJONALITET

//Oppdatering av beskrivelse
//Loader data om rom, itererer gjennom til id matcher. Loader data om spesifikt rom. 
//Oppdaterer variabler med ny info
function update_room($room_id, $name, $description)
{
    $rooms = load_data("rooms");
    foreach($rooms as &$room)
    {
        if($room["id"] == $room_id)
        {
            $room["name"] = $name;
            $room["description"] = $description;
            $description = $room["description"];
            break;
        }
    }
    
    save_data("rooms", $rooms);
}


//loader data fra unavailable_periods, lager ny array med room_id og dato range
//legger til i unavailable_periods, og lagrer data i fil
function set_room_unavailable($room_id, $start_date, $end_date)
{
    $unavailable_periods = load_data("booking");

    if($start_date < $end_date)
    {
        $unavailable_periods[] = 
        [
            "room_id" => $room_id,
            "start_date" => $start_date,
            "end_date" => $end_date
        ];

        save_data("booking", $unavailable_periods);
        return true;
    }
    else
    {
        return false;
    }
}

function get_room_by_id($room_id)
    {
        $rooms = load_data("rooms");
        foreach ($rooms as $room)
        {
            if($room["id"] == $room_id)
            {
                return $room;
            }
        }

        return null;
    }