<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../../config/database.php';
    include_once '../../models/Users.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Users($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->full_name = $data->full_name;
    $item->email = $data->email;
    $item->password = $data->password;
    $item->photo = $data->photo;
    $item->job = $data->job;
    $item->expected_position = $data->expected_position;
    if($item->createUser()){
        echo json_encode('User created successfully.');
    } else{
        echo json_encode('User could not be created.');
    }
?>