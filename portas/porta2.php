<?php
/**
 * Created by PhpStorm.
 * User: Uilian
 * Date: 04/06/2017
 * Time: 03:50
 */
try {
    include '../connection/connection.php';
    //Variaveis recebem os valores passados via GET
    $token = htmlspecialchars($_GET["token"],ENT_QUOTES);
    $sala = htmlspecialchars($_GET["sala"],ENT_QUOTES);
    $controladora = htmlspecialchars($_GET["controladora"],ENT_QUOTES);
    $pstatus2 = htmlspecialchars($_GET["status2"],ENT_QUOTES);
    $nome = "sem cadastro";
    $liberacao = "n";
    $vlr_sala2 = 2;
    $status2 = 3;
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
            $vlr_sala2 = $row['sala2'];
        }


        //Altera o valor da variavel status1 de acordo com o valor obtido na pesquisa controladora
        if (($pstatus2 == 1) and ($vlr_sala2 == 0)):
            $status2 = 1;
            $estado = "abriu";
        elseif (($pstatus2 == 1) and ($vlr_sala2 == 1)):
            $status2 = 1;
            $estado = "abriu";
        elseif (($pstatus2 == 0) and ($vlr_sala2 == 0)):
            $status2 = 0;
            $estado = "fechou";
        elseif (($pstatus2 == 0) and ($vlr_sala2 == 1)):
            $status2 = 0;
            $estado = "fechou";
        elseif ($status2 == 3):
            $status2 = $vlr_sala2;
            $estado = "sem dados";
        endif;

        $log = "insert into log (dt, id, nome, token, sala)
            values (NOW(),NULL,'$nome','$token','$sala')";

        $update_cont = "UPDATE controladora SET sala2=$status2 WHERE nome = '$controladora'";

        $conn->query($update_cont);




        if($liberacao == "s"):

            echo "<porta_1>",$status2,"</porta>";


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