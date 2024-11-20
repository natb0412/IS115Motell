<?php

//Laste inn data
function load_data($file)
{
    return include __DIR__ . "/data/" . $file . '.php';
}


//Lagre data
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



//validering for booking. Returner false hvis du ikke oppfyller krav
function validate_dates($check_in, $check_out)
{
    $now = newdatetime();
    $check_in_date = datetime::createformat("d-m-Y", $check_in);
    $check_out_date = datetime::createformat("d-m-Y", $check_out);

    if(!$check_in_date_in  || !$check_out_datecheck_out)
    {
        reutrn false;
    }

    if($check_in_date < $now || $check_out_date <= $check_in_date)
    {
        return false;
    }

    return true;
}


// Logikk for å finde ledige rom
function find_available_rooms($check_in, $check_out, $adults, $children)
{

}