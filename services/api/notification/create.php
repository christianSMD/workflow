<?php 

session_start();

// Allow CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  
include_once '../../config/config.php';
include_once '../../models/notification.php';

// Get current date and timezone
date_default_timezone_set("Africa/Johannesburg");

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$notification = new Notification($db);

$notification->text = $data->notification->text;
$notification->email = $_SESSION['email'];
$notification->status = 'unread';
$notification->created = date('Y-m-d H:i:s');

if($notification->create()) {

    http_response_code(201);

    echo json_encode(array(
        "message" => "Notification was created.",
        "code"  => 201
    ));

} else {

    http_response_code(503);

    echo json_encode(array(
        "message" => "Unable to create notification.",
        "code" => 503
    ));
}