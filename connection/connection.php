<?php
/**
 * Created by PhpStorm.
 * User: Uilian
 * Date: 03/06/2017
 * Time: 16:53
 */
$host = "localhost";
$user = "root";
$pass = "filipenses413";
$dbname = "heimdall";
$response = new \stdClass();
try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if(empty($conn)){
        $response->message = '<strong>Erro ao acessar a base de dados</strong><br/>';
        $response->message.='<strong>HOST: </strong>'.$host.'<br/>';
        $response->message.='<strong>USER: </strong>'.$user.'<br/>';
        $response->message.='<strong>DATABASE: </strong>'.$dbname.'<br/>';
        $response->message.='<strong>PASS: </strong>'.$pass.'<br/>';
        echo $response;
        echo $conn->connect_error;
        die;
    }
}
catch (Exception $e) {
    $response->status = 0;
    $response->message = 'Ocorreu um erro ao se conectar a base de dados, '.$e->getMessage();
}
?>