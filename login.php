<?php
    require_once "config.php";
    require_once "key.php";

    class Result {}
    $response = new Result();
    //$date = null;
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();
        $results = $stmt->fetchAll();
    }
    catch( PDOException $Exception ) {
        // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
        // String.
        $response->message = $Exception->getCode( );
    }
    if(count($results)>0){
        session_start();
        openssl_public_encrypt($_POST['password'], $encrypted, $pubKey);
        $_SESSION['user'] = $_POST['email'];
        $_SESSION['key'] = $pubKey;
        //$_SESSION['secret'] = $encrypted;
        $response->message = 1;
    }else{
        $response->message = 0;
    }
    
    echo json_encode($response); 
?>