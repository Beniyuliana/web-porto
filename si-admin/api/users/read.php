<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/Users.php';
session_start();


$database = new Database();
$db = $database->getConnection();
if(isset($_GET['id'])){
    $item = new Users($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getSingleUser();
    if($item->full_name != null){
        // create array
        $emp_arr = array(
        "id" => $item->id,
        "full_name" => $item->full_name,
        "email" => $item->email,
        "password" => $item->password,
        "photo" => $item->photo,
        "job" => $item->job,
        "expected_position" => $item->expected_position,      
        );
        http_response_code(200);
        echo json_encode($emp_arr);
    }
    else{
        http_response_code(404);
        echo json_encode("User not found.");
    }
}
else {
    // if (!isset($_SESSION['user'])) {
    //     http_response_code(404);
    //     echo json_encode("You are not log in.");
    //     return false;
    // }
    
    $items = new Users($db);
    $stmt = $items->getUsers();
    $itemCount = $stmt->rowCount();
    if($itemCount > 0){
        $UserArr = array();
        $UserArr["body"] = array();
        $UserArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "full_name" => $full_name,
                "email" => $email,
                "password" => $password,
                "photo" => $photo,
                "job" => $job,
                "expected_position" => $expected_position,
            );
            array_push($UserArr["body"], $e);
        }
        echo json_encode($UserArr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("messstock" => "No record found."));
    }
}
?>