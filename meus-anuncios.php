<?php require 'pages/header.php';?>
<?php 

    //Caso o usuário não esteja logado 
    if(empty($_SESSION['cLogin'])){
        ?>
        <script type="text/javascript">windows.location.href="login.php";</script>
        <?php
        exit;
    }
?>
<div class="container">
    <h1>Meus anúncios</h1>

    <a href="add-anuncio.php" class="btn btn-default">Adicionar anúncio</a><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Titulo</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php
        require 'classes/anuncios.class.php';
        $a = new Anuncios();
        $anuncios = $a->getMeusAnuncios();

        foreach($anuncios as $anuncio): ?>
            <tr>
                <?php 
                
                    if(!empty($anuncio['url'])) { ?>
                    <td><img width="80" height="80" src="assets/images/anuncios/<?php echo $anuncio['url'];?>"></img></td>
                    <?php } 
                    
                    else{?>
                    <td><img width="80" height="80" src="assets/images/produto-sem-imagem.jpg"></img></td>
                    <?php } ?>

                <td><?php echo $anuncio['titulo']; ?></td>

                <td>R$ <?php echo number_format($anuncio['valor'] , 2); ?></td>

                <td><a href="editar-anuncio.php?id=<?php echo $anuncio['id'];?>" class="btn">Editar</a>
                    
                    <a href="excluir-anuncio.php?id=<?php echo $anuncio['id'];?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?> 
    </table>
</div>




<?php require 'pages/footer.php'; ?>