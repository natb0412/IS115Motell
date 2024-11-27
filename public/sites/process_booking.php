<?php
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $guest_name = $_POST['guest_name'];


    $bookings = load_data('bookings');


    $new_booking = [
        'id' => uniqid(),
        'room_id' => $room_id,
        'guest_name' => $guest_name,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'adults' => $adults,
        'children' => $children
    ];


    $bookings[] = $new_booking;

 
    save_data('bookings', $bookings);


    header('Location: booking_confirmation.php');
    exit;
}