<?php 

session_start();

// Allow CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  
include_once '../../config/config.php';
include_once '../../models/user.php';

// Get current date and timezone
date_default_timezone_set("Africa/Johannesburg");

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$user = new User($db);
  
$data = json_decode(file_get_contents("php://input"));
  
if(
    !empty($data->user->email) &&
    !empty($data->user->name) &&
    !empty($data->user->surname)
){
  
    $user->email = $data->user->email;
    $user->name = $data->user->name;
    $user->surname = $data->user->surname;
    $user->created = date('Y-m-d H:i:s');
  
    if($user->create()){

        http_response_code(201);

        $_SESSION['email'] = $data->user->email;

        echo json_encode(array(
            "message" => "user was created.",
            "code"  => 201
        ));

    } else {

        http_response_code(503);
        
        echo json_encode(array(
            "message" => "Unable to create user.",
            "code" => 503
        ));
    }
    
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}