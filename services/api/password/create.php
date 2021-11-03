<?php 

session_start();

// Allow CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  
include_once '../../config/config.php';
include_once '../../models/password.php';

// Get current date and timezone
date_default_timezone_set("Africa/Johannesburg");

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$password = new Password($db);
    
if(
    !empty($data->user->email) &&
    !empty($data->user->password)
){
  
    $password->email = $data->user->email;
    $password->password = $data->user->password;
    $password->created = date('Y-m-d H:i:s');
  
    if($password->create()){

        http_response_code(201);

        echo json_encode(array(
            "message" => "password was created.",
            "code"  => 201
        ));

    } else {

        http_response_code(503);
        
        echo json_encode(array(
            "message" => "Unable to create password.",
            "code" => 503
        ));
    }
    
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create password. Data is incomplete."));
}