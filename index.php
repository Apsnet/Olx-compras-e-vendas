<?php

    require 'pages/header.php';
    require 'classes/anuncios.class.php';
    require 'classes/usuarios.class.php';
    require 'classes/categorias.class.php';

    $a = new Anuncios();
    $u = new Usuarios();
    $c = new Categorias();

    $filtros = array(
        'categoria' => '' ,
        'estado'    => '' ,
        'preco'     => '' ,
    );
    if(isset($_GET['filtros'])){
        $filtros = $_GET['filtros'];
    }
    $total_anuncios = $a->getTotalAnuncios($filtros); //
    $total_usuarios = $u->getTotalUsuarios();

    //Sistema de paginação
    $pagina_atual = 1; //Por padrão 1
    if(isset($_GET['p']) && !empty($_GET['p'])){
        $pagina_atual = $_GET['p'];
    }

    $por_pagina = 2;
    $total_paginas = ceil($total_anuncios / $por_pagina);


    $anuncios = $a->getUltimosAnuncios($pagina_atual , $por_pagina , $filtros);
    $categorias = $c->getLista();

?>
    <div class="container-fluid">
        <div class="jumbotron" id="banner" >
            <!-- <h2>Nós temos hoje <?php echo $total_anuncios; ?> anúncios</h2> -->
            <!-- <p>E mais de <?php echo $total_usuarios; ?> usuários cadastrados</p> -->
        </div>


        <div class="row">
            <div class="col-sm-3">
                <h4>Pesquisa avançada</h4>
                <form method="GET">

                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                        <select name="filtros[categoria]" class="form-control" id="categoria">
                            <option>Selecione</option>
                            <?php foreach($categorias as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"  <?php echo ($cat['id'] == $filtros['categoria'])?'selected="selected"':'';?>><?php echo utf8_encode($cat['nome']); ?></option>

                            <?php endforeach;?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="categoria">Preço:</label>
                        <select name="filtros[preco]" class="form-control" id="preco">
                            <option>Selecione</option>
                            <option value="0-50"    <?php echo ($filtros['preco'] == '0-50')?'selected="selected"':'';?>>R$ 0 - 50</option>
                            <option value="51-100"  <?php echo ($filtros['preco'] == '51-100')?'selected="selected"':'' ;?>>R$ 51 - 100</option>
                            <option value="101-200" <?php echo ($filtros['preco'] == '101-200')?'selected="selected"':'';?>>R$ 101 - 200</option>
                            <option value="201-500" <?php echo ($filtros['preco'] == '201-500')?'selected="selected"':'';?>>R$ 201 - 500</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado de conservação:</label>
                        <select name="filtros[estado]" class="form-control" id="estado">
                            <option>Selecione</option>
                            <option value="0" <?php echo ($filtros['estado'] == '0')?'selected="selected"':'';?>> Ruim</option>
                            <option value="1" <?php echo ($filtros['estado'] == '1')?'selected="selected"':'';?>>Bom</option>
                            <option value="2" <?php echo ($filtros['estado'] == '2')?'selected="selected"':'';?>>Ótimo</option>


                        </select>
                    </div>


                    <div class="form-group">
                        <input type="submit" value="Buscar" class="btn btn-info">
                    </div>

                </form>
            </div>
            <div class="col-sm-9">
                <h4>Últimos anúncios</h4>

                <table class="table table-striped">
                <tbody>
                    <?php
                        foreach($anuncios as $anuncio):?>
                            <tr>
                                <?php
                                    if(!empty($anuncio['url'])) { ?>
                                    <td><img width="80" height="80" src="assets/images/anuncios/<?php echo $anuncio['url'];?>"></img></td>
                                    <?php }

                                    else{?>
                                <td><img width="80" height="80" src="assets/images/produto-sem-imagem.jpg"></img></td>
                                <?php } ?>

                                <td>
                                    <a href="produto.php?id=<?php echo $anuncio['id']; ?>"><?php echo $anuncio['titulo']; ?></a><br />
                                    <?php echo utf8_encode($anuncio['categoria']); ?>
                                </td>

                                <td>R$ <?php echo number_format($anuncio['valor'] , 2); ?></td>
                            </tr>

                        <?php endforeach; ?>
                </tbody>

                </table>


                <ul class="pagination">

                    <?php for($q = 1 ; $q <= $total_paginas ; $q++ ): ?>
                        <li class="<?php echo ($pagina_atual == $q)?'active':''; ?>"><a href="index.php?<?php
                        $w = $_GET;   //Tudo que está no get vai para a variavel
                        $w['p'] = $q; //Adiciona o p da paginação
                        echo http_build_query($w);  //Transforma todo o array em URL
                        ?>"><?php echo $q; ?></a></li>
                    <?php endfor; ?>
                </ul>

            </div>
        </div>

    </div>

<?php

    require 'pages/footer.php';

?>
