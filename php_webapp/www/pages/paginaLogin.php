<?php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Login</h2>
        <p>Preencha o form abaixo <code>.was-validated</code> com os dados de login para acessar o site:</p>
        <p>Termos: Realizando o login, seus dados são protegidos via sessão com JWT, nenhuma informação é armazenada,
            porem o uso dos dados é nescessário para o controle de acesso!
        </p>
        <?php if (isset($_GET["usuario"])) {
                echo '<div class="alert alert-danger" roke="alert" style="text-align:center">';
                    echo 'Nome de usuario e/ou senha esta incorreto!';
                echo '</div>';
            }
        ?>
        <form action="service/rest/login.php" class="was-validated" method="POST">
            <div class="form-group">
                <label for="uname">Username:</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" 
                value="<?php echo $_GET["usuario"];?>" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Favor preencha corretamente o nome de usuario.</div>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pswd" placeholder="Enter password" name="pswd" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Favor preencha corretamente sua senha.</div>
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" required> Aceito os termos.
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Check o checkbox para continuar.</div>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Logar</button>
            <button type="reset" class="btn btn-warning">Limpar</button>
        </form>
        <div class="d-flex align-items-center flex-column">
            <div class="mt-auto p-2">
                <a href="home">
                    <button type="button" class="btn btn-dark">Voltar Home</button>
                </a>
            </div>
        </div>
    </div>

</body>

</html>