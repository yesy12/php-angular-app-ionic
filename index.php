<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

    $srvdb   = "mysql:host=192.168.0.3;dbname=alison";
    $usuario = "curso";
    $senha   = "master";

    $con = new PDO($srvdb, $usuario,$senha,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

    $sql = $con->prepare("select * from paciente");
    $sql->execute();
    $r = $sql->fetchAll(PDO::FETCH_ASSOC);

    function insertPaciente($paciente){
        $valor = array();
        foreach($paciente as $k => $v){
            $valor[] = $v;
        }
        $sql= $GLOBALS['con']->prepare("CALL setPaciente (?,?,?,?,?,?,?,?) ");
        $sql->execute($valor);
        $r = $sql->errorInfo();
        return $r;
    }

    function fazerChamada($guiche){
        $sql = $GLOBALS['con']->prepare("CALL setChamada (?)");
        $sql->execute(array($guiche));
        $r = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

    //Inserir paciente
    /*    
    $paciente = array(
        "email" => "alisonvieira728@yahoo.com.br",
        "nome" =>  "Alison",
        "snome" => "Vieira",
        "endereco"=> "Av Rui Barbosa",
        "cidade" => "Taboão da Serra",
        "estado" => "São Paulo",
        "cep" => "06774330",
        "obs" => " "
    );

    $r = insertPaciente($paciente);
    print_r($r);
    
    $r = fazerChamada(2);
    print_r($r);
    */

    function getPacientes(){
        $sql = $GLOBALS['con']->prepare("select * from paciente ");
        $sql->execute();
        $r = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

    function getChamada (){
        $sql = $GLOBALS['con']->prepare("CALL getChamada()");
        $sql->execute();
        $r = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

    $dados = file_get_contents('php://input');
 
    $decode = false;
    if (strlen($dados) > 0){
        $decode = json_decode($dados,true);
    }

    switch ($decode['opt']){
        case 1: echo json_encode(getPacientes ())                       ;break;
        case 2: echo json_encode(insertPaciente($decode['paciente']))   ;break;
        case 3: echo json_encode(fazerChamada ($decode['guiche' ]))     ;break;
        case 4: echo json_encode(getChamada ())                         ;break;
    }

    if (isset($_GET['evento'])){
        if($_GET['evento'] == "chamada"){
            echo json_encode(getChamada());
        }
    }
?>