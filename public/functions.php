<?php
require_once "config.php";

//DATALAGRING OG SENDING

//Laster inn data. Config inneholder konstanter for BASE og DATA_PATH
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



//Lagre data i DATA_PATH/file.php
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
    return isset($_SESSION["user_id"]) && $_SESSION["is_admin"] ?? false;
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
    if(!$check_in_date || !$check_out_date)
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
function find_available_rooms($start_date, $end_date, $adults, $children)
{
    //henter inn data fra rooms.php, og booking.php.
    //Lager array for ledige rom
    $rooms = load_data("rooms");
    $bookings = load_data("booking");
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
                    if (($start_date >= $booking["start_date"] && $start_date < $booking["end_date"]) ||
                    ($end_date > $booking["start_date"] && $end_date <= $booking["end_date"]) ||
                    ($start_date <= $booking["start_date"] && $end_date >= $booking["end_date"]))
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
    $bookings = load_data("booking");

    //lager ny booking
    $new_booking = 
    [
        "id" => "BOOK" . (count($bookings) + 1),
        "room_id" => $room_id,
        "guest_name" => $guest_name,
        "start_date" => $check_in,
        "end_date" => $check_out,
        "adults" => $adults,
        "children" => $children
    ];
    //legger til ny booking i bookings-arrayen, og lagrer deretter dataen i bookings.php
    $bookings[] = $new_booking;
    save_data("booking", $bookings);
    return $new_booking["id"];
}



//ADMINFUNKSJONALITET
//funksjon til admin "dashboard". Viser om et rom er booka for idag eller imorgen
function is_room_available($room_id, $start_date, $end_date)
{
    $bookings = load_data("booking");
    foreach ($bookings as $booking)
    {
        if ($booking["room_id"] == $room_id)
        {
            if (($start_date >= $booking["start_date"] && $start_date < $booking["end_date"]) 
            ||
            ($end_date > $booking["start_date"] && $end_date <= $booking["end_date"]) 
            ||
            ($start_date <= $booking["start_date"] && $end_date >= $booking["end_date"]))
            {
            return false;
            echo "Ikke tilgjengelig";
            }
        }
    }
    return true;
    echo "Tilgjengelig";
}



//Oppdaterer variabler med ny info
//itererer gjennom alle rom, og setter verdien i matrisen til variablen i parameteret
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



//laster inn et rom basert på romID
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

//sletter en booking, og reindexer arrayen
    function delete_booking($booking_id, $room_id = null)
    {
        $booking = load_data("booking");
        $booking_found = false;

        foreach ($booking as $b => $bookings)
        {
            if (isset($bookings["id"]) && $room_id !== null && isset($booking_id["room_id"]) && $bookings["room_id"] === $room_id)
            {
                unset($booking[$b]);
                $booking_found = true;
                break;
            }
        }

        if (!$booking_found)
        {
            return false; 
        }

        save_data("booking", array_values($booking));
        return true;
    }