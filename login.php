<?php require 'pages/header.php';?>



<div class="container">
    <h1>Fazer login</h1>

    <?php
    require 'classes/usuarios.class.php';
    $u = NEW Usuarios();

    if(isset($_POST['email']) && !empty($_POST['email'])){

            $email    = $_POST['email'];
            $senha    = md5($_POST['senha']);
            $ip       = $_SERVER['REMOTE_ADDR'];

            if($u->login($email , $senha)){
                //Redirecionamento com javascript
            ?>
                <script type="text/javascript">window.location.href="./";</script>

            <?php
            }else{
                ?>
                <div class="alert alert-danger">
                    Usuário e/ou senha errados;
                </div>
                <?php
            }

    }
    ?>

    <form method="POST">


        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control">
        </div>


        <input type="submit" value="Login" class="btn btn-default" >
    </form>

</div>
<?php require 'pages/footer.php'; ?>
