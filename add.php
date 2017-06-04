<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Parametros de base de datos
$mysql_servidor = "localhost";
$mysql_base = "apkma792_heimdall";
$mysql_usuario = "apkma792_heimdal";
$mysql_pass = "heimdall";


$token = htmlspecialchars($_GET["token"],ENT_QUOTES);
$sala = htmlspecialchars($_GET["sala"],ENT_QUOTES);
$controladora = htmlspecialchars($_GET["controladora"],ENT_QUOTES);
$pstatus1 = htmlspecialchars($_GET["status1"],ENT_QUOTES);
$pstatus2 = htmlspecialchars($_GET["status2"],ENT_QUOTES);
$pstatus3 = htmlspecialchars($_GET["status3"],ENT_QUOTES);



// Valida que esten presente todos los parametros
if (($token!="") and ($sala!="")) {
    mysql_connect($mysql_servidor,$mysql_usuario,$mysql_pass) or
       die("Impossivel conectar.");
    mysql_select_db($mysql_base) or die("Impossivel abrir o banco de dados");

    $nome = "n?o cadastrado";
    $liberacao = "n";

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
    $status1 = 0;
    }
    if($pstatus1 == 1){
    $status1 = 1;
    }  
    if($pstatus2 == 0){
    $status2 = 0;
    }
    if($pstatus2 == 1){
    $status2 = 1;
    }   
    if($pstatus3 == 0){
    $status3 = 0;
    }
    if($pstatus3 == 1){
    $status3 = 1;
    }    
    
    
    
    $sql2 = "UPDATE controladora SET sala1=$status1,sala2=$status2,sala3=$status3 WHERE nome = '$controladora'";
    mysql_query($sql2);
    
    
    
    
    
    	$p1 = "2";
        $p2 = "2";
        $p3 = "2";
    $pesquisa="SELECT  sala1, sala2, sala3 FROM `controladora` WHERE nome ='$controladora'";
	$resultado= mysql_query($pesquisa);
    while ($row = mysql_fetch_assoc($resultado)) {
        $p1 = $row['sala1'];
        $p2 = $row['sala2'];
        $p3 = $row['sala3'];

    }


       
    //echo $nome;
    //echo $liberacao;
    
    //echo $sql2;
    
    
    if($liberacao == "s"):
    echo "<porta_1>",$p1,"</porta_1>","<porta_2>",$p2,"</porta_2>","<porta_3>",$p3,"</porta_3>";
else:
     echo"n���o liberado";
endif;




}
?>