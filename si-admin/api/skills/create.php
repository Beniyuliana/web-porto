<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../../config/database.php';
    include_once '../../models/Skills.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Skills($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->user_id = $data->user_id;
    $item->skill_name = $data->skill_name;
    $item->rating = $data->rating;
    $item->description = $data->description;
    if($item->createSkills()){
        echo json_encode(["message" => 'User created successfully.']);
    } else{
        echo json_encode('User could not be created.');
    }
?>