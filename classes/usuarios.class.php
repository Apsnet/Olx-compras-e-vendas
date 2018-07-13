<?php 


class Usuarios{

    public function getTotalUsuarios(){
        global $pdo;

        $sql = $pdo->query("SELECT COUNT(*) as c FROM usuario");
        $row = $sql->fetch();

        return $row['c'];
    }

    public function cadastrar($nome , $email , $senha , $telefone){
        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM usuario WHERE email = :email ");
        $sql->bindValue("email" , $email);
        $sql->execute();

        //Insere o usuario
        if($sql->rowCount() <= 0){
                $sql = $pdo->prepare("INSERT INTO usuario SET nome = :nome , email = :email , senha= :senha , telefone =:telefone");
                $sql->bindValue(":nome",$nome);
                $sql->bindValue(":email",$email);
                $sql->bindValue(":senha",$senha);
                $sql->bindValue(":telefone",$telefone);
                $sql->execute();

                return true;
        //Usuario já é cadastrado no sistema
        }else{
            
                return false;
        }

    }


    public function login($email , $senha){
        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM usuario WHERE email = :email AND senha=:senha");
        $sql->bindValue(":email" ,$email);
        $sql->bindValue(":senha" , $senha);
        $sql->execute();

        if($sql->rowCount() > 0){

            $dado = $sql->fetch();
            $_SESSION['cLogin'] = $dado['id'];
            return true;
        }else{
            return false;
        }
    }

    public function nome_usuario(){

        $pdo;

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE id = :id");
        $sql->bindValue(":nome" , $_SESSION['cLogin']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados = $sql->fetch();
            $dados = $dados['nome'];
            echo $nome;
        
        }
        
    }


    public function verifica_ip($id , $ip){

        $sql = "SELECT * FROM usuarios WHERE id=:id AND ip=:ip";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":id" , $_SESSION['cLogin']);
        $sql->bindValue(":ip" , $_SERVER['REMOTE_ADDR']);
        $sql->execute();
        
        if($sql->rowCount() == 0){
            return false;
        }else{
            return true;
        }
    }
    
}