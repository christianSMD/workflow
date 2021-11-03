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
$num = 0;

if($data->user->action == 'logout') {

    session_unset();
    session_destroy();

    http_response_code(200);
    echo json_encode(array(
        "message" => "Unable to load user. Data is incomplete.",
        "code" => 200
    ));

} else {

    if(!empty($data->user->email) && !empty($data->user->password)) {

        $message = '';
        $user->email = $data->user->email;
        $user->password = $data->user->password;
        $user->action = $data->user->action;
    
        if($user->action == 'read_single') {
    
            $data = $user->read_single();
            $num = $data->rowCount();
            
            while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  
                extract($row);
    
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $name;
                $_SESSION['surname'] = $surname;
    
            }
    
            http_response_code(200);
            echo json_encode(array(
                "message" => 'Record loeaded',
                "code" => 200,
                "num" => $num
            ));
    
        } else {
    
            $data = $user->read();
            $arr = array();
    
            if($num > 0) {
    
                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
            
                  $results = array(
                    'user_id' => $user_id,
                    'email' => $email,
                    'name' => $name,
                    'surname' => $surname,
                    'created' => $created
                  );
                  
                  // Push to "data"
                  array_push($arr, $results);
                }
            
            
            } else {
    
                http_response_code(200);
                echo json_encode(array(
                    "message" => "0 records",
                    "results" => 0
                ));
    
            }
    
        }
        
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to load user. Data is incomplete."));
    }

}

