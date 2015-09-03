<?php
    require_once "config.php";
    
    $response ="";
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
        $_SESSION['user'] = $_POST['email'];
        $response = 'OK';
    }else{
        $response = $_POST['email'];
    }
    
    

    echo $response;
?>