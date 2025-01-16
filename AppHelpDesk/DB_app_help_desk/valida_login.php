<?php
session_start();


//variavel que identifica se a autenticação foi realizada
$usuario_Autenticado = false;
$usuario_id=null;
$usuario_perfil_id = null;

$perfis = array(1 => 'Administrativo', 2 => 'Usuario');

//usuarios do sistema
$lista_Usuarios = array(
    array('id' => 1, 'email' => 'admin@teste.com.br','senha' => '1234','perfil_id' => 1),
    array('id' => 2,'email' => 'user@teste.com.br','senha' => '1234','perfil_id' => 1),
    array('id' => 3,'email' => 'joao@teste.com.br','senha' => '1234','perfil_id' => 2),
    array('id' => 4,'email' => 'maria@teste.com.br','senha' => '1234','perfil_id' => 2)
);


foreach($lista_Usuarios as $user){
    
    if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']){
        $usuario_Autenticado = true;
        $usuario_id = $user['id'];
        $usuario_perfil_id = $user['perfil_id'];
    }
}

if($usuario_Autenticado == true){
    echo 'Usuário autenticado';
    $_SESSION['autenticado'] = 'SIM';
    $_SESSION['id'] = $usuario_id;
    $_SESSION['perfil_id'] = $usuario_perfil_id;
    header('Location: home.php');
}
else{
    $_SESSION['autenticado'] = 'NAO';
    header('Location: index.php?login=erro');
}


?>