<?php
$users = [
    "Ivan" => "12345",
    "Alex" => "54321"
];

session_start();

if (isset($_POST["users"]) && !isset($_SESSION["users"]))
{
    if ($users[$_POST["users"]] == $_POST["password"])
    {
        $_SESSION["users"] = $_POST["users"];
    }

    if (!isset($_SESSION["users"])) 
    {
        $failed = true;
    }
}

if (isset($_SESSION["users"]))
{
    header("Location: test_index.php");
    exit();
}

?>