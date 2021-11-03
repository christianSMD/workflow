<?php

session_start();
http_response_code(200);

if(isset($_SESSION['user_id'])) {
   
    echo json_encode(array(
        "name" => $_SESSION['name'],
        "surname" => $_SESSION['surname'],
        "email" => $_SESSION['email'],
        "state" => 1
    ));

} else {

    echo json_encode(array(
        "state" => 0
    ));
}