<?php

function load_data($fil)
{
    return include __DIR__ . "/data/" . $file . '.php';
}

function save_data($file, $data)
{
    $content = "<php\nreturn " . var_export($data, true) . ";\n";
    file_put_contents(__DIR__ . "/data/" . $file . ".php", $content);
}

function is_logged_in()
{
    return isset($_SESSION["user_id"]);
}

function is_admin()
{
    return isset($_SESSION["user_id"]) && $_SESSION["is_admin"];
}

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
}