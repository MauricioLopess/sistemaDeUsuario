<?php
require_once("../header.php");
require_once("../database/db_conn.php");
session_start();

if(isset($_POST['bt-enviar'])){
    $erros = array();
    
    $nome = mysqli_escape_string($conn, $_POST['name']);
    $usuario = mysqli_escape_string($conn, $_POST['user']);
    $senha = mysqli_escape_string($conn, $_POST['password']);

    if(empty($nome) || empty($usuario) || empty($senha)){
        $erros[] = "<li>Insira os campos corretamente</li>";
    }else{
        // verifica se existe algum usuário com o mesmo nome inserido no formuário
        $sql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario';";
        $res = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($res) > 0){
            $erros[] = "<li>Usuário já existente, tente novamente</li>";
        }else{
            $senha = md5($senha);
            $sql = "INSERT INTO usuarios(nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha');";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            $_SESSION['logado'] = false;
            header("Location: login.php");
        }
    }

}
?>

<h2>Insira seus dados</h2>

<?php
if(!empty($erros)){
    echo "<hr>";
    foreach($erros as $erro){
        echo $erro;
    }
    echo "<hr>";
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="name">Nome</label><br>
    <input type="text" name="name" id="name"><br>

    <label for="user">Usuário</label><br>
    <input type="text" name="user" id="user"><br>

    <label for="password">Senha</label><br>
    <input type="password" name="password" id="password"> <br><br>

    <button type="submit" name="bt-enviar">Enviar</button>
</form>
<hr>
<a href="../">Voltar</a>