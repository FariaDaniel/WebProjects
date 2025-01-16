<?php 
    session_start();

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    //tratando o formulario recebido
    $titulo = str_replace('#','-',$_POST['titulo']);
    $categoria = str_replace('#','-',$_POST['categoria']);
    $descricao = str_replace('#','-',$_POST['descricao']);

    //abre arquivo ou cria caso nao exista
    $arquivo = fopen('../BD_app_help_desk/arquivo.hd','a');

    $texto =$_SESSION['id'] . '#' . $titulo . '#' . $categoria .'#' . $descricao . PHP_EOL;
    //escreve no arquivo o texto tratado
    fwrite($arquivo, $texto);
    //fecha o arquivo
    fclose($arquivo);

    //echo $texto;
    header('Location: abrir_chamado.php?log=sucesso');
?>
