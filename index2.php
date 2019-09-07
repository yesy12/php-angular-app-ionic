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
?>
<html>
    <table border="1">
        <tr>
            <td> Nome</td>
            <td> Sobrenome </td>
            <td> Email </td>
            <td> Endereço </td>
            <td> Cidade </td>
            <td> Estado </td>
            <td> Cep </td>
            <td> Obs </td>
            <td> Registro </td>
        </tr>
        <?php 
            foreach($r as $paciente){
        ?>
        <tr>
            <td> <?php echo $paciente["nome"]; ?> </td>
            <td> <?php echo $paciente["snome"]; ?> </td>
            <td> <?php echo $paciente["email"]; ?> </td>
            <td> <?php echo $paciente["endereco"]; ?> </td>
            <td> <?php echo $paciente["cidade"]; ?> </td>
            <td> <?php echo $paciente["estado"]; ?> </td>
            <td> <?php echo $paciente["cep"]; ?> </td>
            <td> <?php echo $paciente["obs"]; ?> </td>
            <td> <?php echo $paciente["dataRegistro"]; ?> </td>
        </tr>

        <?php } ?>

    </table>
</html>