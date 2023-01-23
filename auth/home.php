<?php
require_once("../header.php");
session_start();

//Validação
if($_SESSION['logado'] != true){
    header("Location: ../");
}

//Captura dos dados do usuário
$dados = array($_SESSION['dados']);

?>

<h3>Bem vindo, <?php echo $dados[0]['nome']; ?></h3>
<hr>
<a href="logout.php">Sair</a>