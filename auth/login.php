<?php
require_once("../header.php");
require_once("../database/db_conn.php");
session_start();

if(isset($_POST['bt-enviar'])){
    $erros = [];
    $usuario = mysqli_escape_string($conn, $_POST['user']);
    $senha = mysqli_escape_string($conn, $_POST['password']);

    if(empty($usuario) || empty($senha)){
        $erros[] = "<li>Insira os campos corretamente</li>";
    }else{
        $sql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) <= 0){
            $erros[] = "<li>Usuário não encontrado</li>";
        }else{
            $senha = md5($senha);
            $sql = "SELECT nome, usuario, senha FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
            $res = mysqli_query($conn, $sql);
            mysqli_close($conn);

            if(mysqli_num_rows($res) != 1){
                $erros[] = "<li>Usuário/senha incorreto, tente novamente</li>";
            }else{
                $_SESSION['logado'] = true;
                $_SESSION['dados'] = mysqli_fetch_array($res);
                // var_dump($_SESSION['dados']);
                header("Location: home.php");
            }
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
    <label for="user">Usuário</label> <br>
    <input type="text" name="user" id="user"> <br>

    <label for="password">Senha</label> <br>
    <input type="password" name="password" id="password"> <br> <br>

    <button type="submit" name="bt-enviar">Enviar</button>
</form>
<hr>
<a href="../">Voltar</a>