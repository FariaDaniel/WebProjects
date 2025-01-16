<?php 

    session_start();

        //remover indices especificos session
        //unset();


        //remove todos os indices da session
        //ssesion_destroy(); se usar 
        //Neste caso é recomendado forçar o redirecinamento para alguma pagina

    session_destroy();
    header('Location: index.php');



?>