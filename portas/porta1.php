<?php
/**
 * Created by PhpStorm.
 * User: Uilian
 * Date: 03/06/2017
 * Time: 16:50
 */
try {
    include '../connection/connection.php';
    //Variaveis recebem os valores passados via GET
    $token = htmlspecialchars($_GET["token"],ENT_QUOTES);
    $sala = htmlspecialchars($_GET["sala"],ENT_QUOTES);
    $controladora = htmlspecialchars($_GET["controladora"],ENT_QUOTES);
    $pstatus1 = htmlspecialchars($_GET["status1"],ENT_QUOTES);
    $nome = "sem cadastro";
    $liberacao = "n";
    $vlr_sala1 = 2;
    $status1 = 3;
    $estado = "";

    //Verifica se o token e a sala esta sem dados
    if (($token!="") and ($sala!="")) {
        //busca pelo token
        $search_user = "SELECT nome, liberado FROM usuario WHERE token = '$token'";
        $result_log = @$conn->query($search_user);
        while($row = $result_log->fetch_assoc()){
            $nome = $row['nome'];
            $liberacao = $row['liberado'];
        }





        // Pesquisa controladora e retorna o status da sala
        $search_controladora="SELECT  sala1, sala2, sala3 FROM `controladora` WHERE nome ='$controladora'";
        $result_cont = @$conn->query($search_controladora);
        while($row = $result_cont->fetch_assoc()){
            $vlr_sala1 = $row['sala1'];
        }


        //Altera o valor da variavel status1 de acordo com o valor obtido na pesquisa controladora
        if (($pstatus1 == 1) and ($vlr_sala1 == 0)):
            $status1 = 1;
            $estado = "abriu";
        elseif (($pstatus1 == 1) and ($vlr_sala1 == 1)):
            $status1 = 1;
            $estado = "abriu";
        elseif (($pstatus1 == 0) and ($vlr_sala1 == 0)):
            $status1 = 0;
            $estado = "fechou";
        elseif (($pstatus1 == 0) and ($vlr_sala1 == 1)):
            $status1 = 0;
            $estado = "fechou";
        elseif ($status1 == 3):
            $status1 = $vlr_sala1;
            $estado = "sem dados";
        endif;

        $log = "insert into log (dt, id, nome, token, sala)
            values (NOW(),NULL,'$nome','$token','$sala')";

        $update_cont = "UPDATE controladora SET sala1=$status1 WHERE nome = '$controladora'";

        $conn->query($update_cont);




        if($liberacao == "s"):

            echo $status1;
            echo "       ";
            echo $estado;
        else:
            echo"sem cadastro";
        endif;
    }



}
catch (Exception $e) {
    $response->status = 0;
    $response->message = 'Ocorreu um erro ao se conectar a base de dados, '.$e->getMessage();
}



?>