<?php
session_start();

include_once '../../config/config.php';
include_once '../../models/notification.php';

  $database = new Database();
  $db = $database->connect();

  $notification = new Notification($db);

  $notification->email = $_SESSION['email'];
  $data = $notification->read_single();

  $num = $data->rowCount();

  $arr = array();

  if($num > 0) {

    while($row = $data->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $results = array(
        'notification_id' => $notification_id,
        'text' => $text,
        'email' => $email,
        'status' => $status,
        'created' => $created,
        'num' => $num
      );
      
      // Push to "data"
      array_push($arr, $results);
    }

    $msg = 'success';

  } else {
    $results = array(
        'note_id' => '',
        'tid' => '',
        'text' => '',
        'created' => ''
      );
    array_push($arr, $results);
    $msg = '0';
  }


  echo json_encode(array(
    'rows' => $num,
    'list'      =>  $arr,
    'message'   =>  $msg
  ));