<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);


$mysql_servidor = "localhost";
$mysql_base = "apkma792_heimdall";
$mysql_usuario = "apkma792_heimdal";
$mysql_pass = "heimdall";


$token = htmlspecialchars($_GET["token"],ENT_QUOTES);
$sala = htmlspecialchars($_GET["sala"],ENT_QUOTES);
$controladora = htmlspecialchars($_GET["controladora"],ENT_QUOTES);
$pstatus1 = htmlspecialchars($_GET["status1"],ENT_QUOTES);
$nome = "sem cadastro";
$liberacao = "n";



// Valida que esten presente todos los parametros
if (($token!="") and ($sala!="")) {
    mysql_connect($mysql_servidor,$mysql_usuario,$mysql_pass) or
    die("Impossivel conectar.");
    mysql_select_db($mysql_base) or die("Impossivel abrir o banco de dados");

    //pesquisa se o cart?o lido est? cadastrado
    $search = "SELECT nome, liberado FROM usuario WHERE token = '$token'";
    $result= mysql_query($search);
    while ($row = mysql_fetch_assoc($result)) {
        $nome = $row['nome'];
        $liberacao = $row['liberado'];

    }
    // insere no log  a hora e dados de acesso
    $sql = "insert into log (dt, id, nome, token, sala)
            values (NOW(),NULL,'$nome','$token','$sala')";


    mysql_query($sql);


    if($pstatus1 == 0){
        $status1 = 1;
    }
    if($pstatus1 == 1){
        $status1 = 0;
    }




    $sql2 = "UPDATE controladora SET sala1=$status1 WHERE nome = '$controladora'";
    mysql_query($sql2);





    $p1 = "2";

    $pesquisa="SELECT  sala1, sala2, sala3 FROM `controladora` WHERE nome ='$controladora'";
    $resultado= mysql_query($pesquisa);
    while ($row = mysql_fetch_assoc($resultado)) {
        $p1 = $row['sala1'];
        $p2 = $row['sala2'];
        $p3 = $row['sala3'];

    }






    if($liberacao == "s"):
        echo "<porta_1>",$p1,"</porta_1>";
    else:
        echo"sem cadastro";
    endif;




}
?>