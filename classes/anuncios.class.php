<?php

class Anuncios{

    public function getTotalAnuncios($filtros){
        global $pdo;

        $filtro_string = array('1=1'); //Pra não dar erro no WHERE caso seja vazio
        
                if(!empty($filtros['categoria']) && $filtros['categoria'] != "Selecione" ){
                    $filtro_string[] = 'anuncios.id_categoria =:id_categoria';
                }
        
                if(!empty($filtros['preco']) && $filtros['preco'] != "Selecione"){
                    $filtro_string[] = 'anuncios.valor BETWEEN :preco1 AND :preco2';
                }
        
                if(!empty($filtros['estado']) && $filtros['estado'] != "Selecione" ){
                    $filtro_string[] = 'anuncios.estado =:estado';
                }


        $sql = $pdo->prepare("SELECT COUNT(*) as c FROM anuncios WHERE ".implode(' AND ' , $filtro_string));
        
        if(!empty($filtros['categoria']) && $filtros['categoria'] != "Selecione" ){
            $sql->bindValue(":id_categoria" , $filtros['categoria']);
        }

        if(!empty($filtros['preco']) && $filtros['preco'] != "Selecione"){
            $preco = explode('-' , $filtros['preco']);
            
            $sql->bindValue(":preco1" , $preco[0]);
            $sql->bindValue(":preco2" , $preco[1]);

        }

        if(!empty($filtros['estado']) && $filtros['estado'] != "Selecione" ){
            $sql->bindValue(":estado" , $filtros['estado']);
        }

        $sql->execute();
        $row = $sql->fetch();

        return $row['c'];
    }


    public function getUltimosAnuncios($pagina_atual , $porPagina , $filtros){
        global $pdo;

        $offset = ($pagina_atual - 1) * $porPagina; //Indice começa em 0 , porPagina é a quantidade de itens na página
        $array = array();

        $filtro_string = array('1=1'); //Pra não dar erro no WHERE caso seja vazio

        if(!empty($filtros['categoria']) && $filtros['categoria'] != "Selecione" ){
            $filtro_string[] = 'anuncios.id_categoria =:id_categoria';
        }

        if(!empty($filtros['preco']) && $filtros['preco'] != "Selecione"){
            $filtro_string[] = 'anuncios.valor BETWEEN :preco1 AND :preco2';
        }

        if(!empty($filtros['estado']) && $filtros['estado'] != "Selecione" ){
            $filtro_string[] = 'anuncios.estado =:estado';
        }

        $sql = $pdo->prepare("SELECT * , 
        (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1 ) as url ,
        (select categorias.nome from categorias where categorias.id = anuncios.id_categoria  ) as categoria
        FROM anuncios WHERE ".implode(' AND ' , $filtro_string)." ORDER BY id DESC LIMIT $offset , $porPagina");
        
        if(!empty($filtros['categoria']) && $filtros['categoria'] != "Selecione" ){
            $sql->bindValue(":id_categoria" , $filtros['categoria']);
        }

        if(!empty($filtros['preco']) && $filtros['preco'] != "Selecione"){
            $preco = explode('-' , $filtros['preco']);
            
            $sql->bindValue(":preco1" , $preco[0]);
            $sql->bindValue(":preco2" , $preco[1]);

        }

        if(!empty($filtros['estado']) && $filtros['estado'] != "Selecione" ){
            $sql->bindValue(":estado" , $filtros['estado']);
        }



        $sql->execute();

        
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }

   

    public function getMeusAnuncios(){
        global $pdo;
        $array = array();

        $sql = $pdo->prepare("SELECT * , 
        (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1 ) as url 
        FROM anuncios WHERE id_usuario=:id_usuario");
        $sql->bindValue(":id_usuario" , $_SESSION['cLogin']);
        $sql->execute();

        
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function addAnuncio($titulo , $categoria , $valor , $descricao , $estado){
        global $pdo ;

        $sql ="INSERT INTO anuncios SET titulo=:titulo , valor =:valor , descricao=:descricao ,
        estado=:estado , id_categoria =:id_categoria , id_usuario=:id_usuario ";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":titulo" ,$titulo);
        $sql->bindValue(":valor" ,$valor);
        $sql->bindValue(":descricao" ,$descricao);
        $sql->bindValue(":estado" ,$estado);
        $sql->bindValue(":id_categoria" ,$categoria);
        $sql->bindValue(":id_usuario" ,$_SESSION['cLogin']);

        $sql->execute();
    }


    public function getAnuncios($id){
        $array = array();

        global $pdo;

        $sql = $pdo->prepare("SELECT * , (select categorias.nome from categorias where categorias.id = anuncios.id_categoria  ) as categoria ,
        (select usuario.telefone from usuario where usuario.id = anuncios.id_usuario  ) as telefone
         FROM anuncios WHERE id=:id");
        $sql->bindValue(":id" , $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $array['fotos'] = array();

            //Pegar as imagens

            $sql = $pdo->prepare("SELECT * FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
            $sql->bindValue(":id_anuncio" , $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                $array['fotos'] = $sql->fetchAll();
            }
        }

        return $array;
    }

    public function editAnuncio($titulo , $categoria , $valor , $descricao , $estado , $fotos , $id){
        global $pdo ;

        $sql ="UPDATE anuncios SET titulo=:titulo , valor =:valor , descricao=:descricao ,
        estado=:estado , id_categoria =:id_categoria , id_usuario=:id_usuario  WHERE id=:id";

        $sql = $pdo->prepare($sql);
        $sql->bindValue(":titulo" ,$titulo);
        $sql->bindValue(":valor" ,$valor);
        $sql->bindValue(":descricao" ,$descricao);
        $sql->bindValue(":estado" ,$estado);
        $sql->bindValue(":id_categoria" ,$categoria);
        $sql->bindValue(":id_usuario" ,$_SESSION['cLogin']);
        $sql->bindValue(":id" , $id);
        $sql->execute();

        if(count($fotos) > 0){
            
            for($q = 0 ; $q < count($fotos['tmp_name']) ; $q++){

                $tipo = $fotos['type'][$q];

                if(in_array($tipo ,array('image/jpeg' , 'image/png') )){
                    $extensao = pathinfo($fotos['name'][$q] , PATHINFO_EXTENSION );
                    $tpmname = md5(time().rand(0,9999)).'.'.$extensao;
                    move_uploaded_file($fotos['tmp_name'][$q] , 'assets/images/anuncios/'.$tpmname);
                    
                    //Redimensionar foto
                    list($width_orig , $height_orig) = getimagesize('assets/images/anuncios/'.$tpmname);
                    $ratio = $width_orig / $height_orig;

                    //Alturas e larguras máximas
                    $width  = 500;
                    $height = 500;

                    if($width / $height > 0){ //Caso a largura esteja maior proporcionalmente
                        $width = $height*$ratio;
                    }else{   //Caso a altura esteja maior proporcionamente 
                        $height = $width*$ratio;
                    }
                    
                    $img = imagecreatetruecolor($width , $height);
                    if($tipo == 'image/jpeg'){
                        $origi = imagecreatefromjpeg('assets/images/anuncios/'.$tpmname);
                    }elseif($tipo == 'image/png'){
                        $origi = imagecreatefrompng('assets/images/anuncios/'.$tpmname);
                    }
                    
                    imagecopyresampled($img , $origi , 0 , 0 , 0 , 0 , $width , $height , $width_orig , $height_orig);

                    imagejpeg($img ,'assets/images/anuncios/'.$tpmname , 80);
                    
                    $sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id_anuncio ,  url =:endereco");
                    $sql->bindValue(":id_anuncio" , $id);
                    $sql->bindValue(":endereco" , $tpmname);
                    $sql->execute();
                }

            }
               
               
        }
    }




    public function excluirAnuncio($id){

        global $pdo;

        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio=:id_anuncio");
        $sql->bindValue(":id_anuncio" , $id);
        $sql->execute();

        $sql = $pdo->prepare("DELETE FROM anuncios WHERE id=:id");
        $sql->bindValue(":id" , $id);
        $sql->execute();

    }


    public function excluirFoto($id){
        
                global $pdo;

                $id_anuncio = 0;
                $sql = $pdo->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id = :id");
                $sql->bindValue(":id" , $id);
                $sql->execute();

                if($sql->rowCount() > 0){
                    $dados = $sql->fetch();
                    $id_anuncio = $dados['id_anuncio'];
                }


                $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id=:id");
                $sql->bindValue(":id" , $id);
                $sql->execute();
                
                return $id_anuncio;
        
            }
}


?>