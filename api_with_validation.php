<?php

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
   endpoint();
}

/**
 * API endpoint to validate submitted 
 * @param string $_POST['first_name']
 * @param string $_POST['last_name']
 * @param email  $_POST['email']
 * @return json encoded response
 */
function endpoint(){

    $errorMsgBag = [];
    $first_name = $last_name = $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = trim($_POST["first_name"]);
        $last_name = trim($_POST["last_name"]);
        $email = trim($_POST["email"]);
    }

    //params validation
    //String, max length 50 , required
    if( empty($first_name) ){ 
        $errorMsgBag['first_name']['empty'] = "First name cannot be empty!";
    }else{
        if( strlen($first_name) > 50 ){
            $errorMsgBag['first_name']['length'] = "First name can be 50 characters long only!";
        }
        if( !preg_match("/^[a-zA-Z-' ]*$/",$first_name) ){
            $errorMsgBag['first_name']['format'] = "Only alphabets and spaces are allowed in first name!";
        }
    }

    //String, max length 50, required
    if( empty($last_name) ){ 
        $errorMsgBag['last_name']['empty']  = "Last name cannot be empty!";
    }else{
        if( strlen($last_name) > 50 ){
            $errorMsgBag['last_name']['length'] = "Last name can be 50 characters long only!";
        }
        if( !preg_match("/^[a-zA-Z-' ]*$/",$last_name) ){
            $errorMsgBag['last_name']['format'] = "Only alphabets and spaces are allowed in last name!";
        }
    }

    //Email format, max length 50, not required
    if( empty($email) ){ 
        // $errorMsgBag['email'] = "Provide email !";
    }else{
        if( strlen($email) > 50 ){
            $errorMsgBag['email']['length'] = "";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorMsgBag['email']['format'] = "Invalid email format!";
        }
    }

    //create API response array
    if( !empty($errorMsgBag) ){
        $response = array(
            "success" => false,
            "error" => $errorMsgBag
        );
    }else{
        $response = array(
            "success" => true,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
        );
    }

    //return JSON encoded array in response 
    header("Content-Type: application/json");
    echo json_encode( $response );

    exit;
}
