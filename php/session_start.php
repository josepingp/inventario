<?php


//Almacenado datos
$user = stringCleaner($_POST["login_user"]);
$Key = stringCleaner($_POST["login_key"]);

// verificando campos obligatorios
if (
    $user == '' ||
    $Key == ''
) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has rellenado todos los campos obligatorios.    
        </div>
        ';
    exit();
}

// Verificando integridad de los datos
if (dataVerify("[a-zA-Z0-9ñÑ]{4,29}", $user)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no coincide con el formato.    
        </div>
        ';
    exit();
}

if ( dataVerify("[a-zA-Z0-9$@.-]{7,100}", $Key) ) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La Clave no coincide con el formato. 
        </div>
        ';
    exit();
}

$userCheck = conexion();
$userCheck = $userCheck->query("SELECT * FROM user WHERE user_user = '$user'");

if ($userCheck->rowCount() == 1) {

    $userCheck = $userCheck->fetch();

    if (
        $userCheck['user_user'] == $user && 
        password_verify($Key, $userCheck['user_key']) 
        ) {
        $_SESSION['id'] = $userCheck['user_id'];
        $_SESSION['name'] = $userCheck['user_name'];
        $_SESSION['last_name'] = $userCheck['user_last_name'];
        $_SESSION['user_user'] = $userCheck['user_user'];

        if (headers_sent()) {
            echo "<script> window.location.href='index.php?view=home' </script>";
        } else {
            header('location: index.php?view=home');
        }
        
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Usuario o clave incorrectos.    
        </div>
        ';
    }
    
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Usuario o clave incorrectos.    
        </div>
        ';
}
$userCheck = null;