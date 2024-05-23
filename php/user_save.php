<?php

require_once "./main.php";
#almaenando datos
$userName = stringCleaner($_POST["user_name"]);
$userLastName = stringCleaner($_POST["user_last_name"]);

$userUser = stringCleaner($_POST["user_user"]);
$userEmail = stringCleaner($_POST["user_email"]);

$userKey1 = stringCleaner($_POST["user_key_1"]);
$userKey2 = stringCleaner($_POST["user_key_2"]);

// verificando campos obligatorios
if (
    $userName == '' ||
    $userLastName == '' ||
    $userUser == '' ||
    $userKey1 == '' ||
    $userKey2 == ''
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
if (dataVerify("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $userName)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $userLastName)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El APELLIDO no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[a-zA-Z0-9ñÑ]{4,29}", $userUser)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[a-zA-Z0-9$@.-]{7,100}", $userKey1) || dataVerify("[a-zA-Z0-9$@.-]{7,100}", $userKey2)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las Claves no coincide con el formato.    
        </div>
        ';
    exit();
}

//Verificando Email
if ($userEmail != '') {
    if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $checkEmail = conexion();
        $checkEmail = $checkEmail->query("SELECT user_email FROM user WHERE user_email = '$userEmail'");

        if ($checkEmail->rowCount() > 0) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EMAIL ya existe en la base de datos.    
            </div>
        ';
            exit();
        }

        $checkEmail = null;
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EMAIL no es valido.    
            </div>
        ';
        exit();
    }
}

//Validando el usuario
$checkUser = conexion();
$checkUser = $checkUser->query("SELECT user_user FROM user WHERE user_user = '$userUser'");

if ($checkUser->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO ya existe en la base de datos.    
        </div>
    ';
    exit();
}

$checkUser = null;

//Verificando que las contraseñas coincidan
if ($userKey1 != $userKey2) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las claves no coinciden.    
        </div>
    ';
    exit();
} else {
    $userKey = password_hash($userKey1, PASSWORD_BCRYPT, ["cost" => 10]);
}

//Guardando datos en la base de datos
$userSave = conexion();
//Esta seria la query normal
//$userSave = $userSave->query("INSERT INTO user(user_name, user_last_name, user_user, user_key, user_email) VALUES ('$userName', '$userLastName', '$userUser', '$userKey', '$userEmail')");

//Esta seria preparar la query pero no ejecutarla, mejor para que no nos puedan inyectar codigo
$userSave = $userSave->prepare("INSERT INTO user(user_name, user_last_name, user_user, user_key, user_email) VALUES (:name, :last_name, :user, :key, :email)");//en ved de colocar variables colocas marcadores usando los :

//Declaramos un array con los marcadores
$markers = [
    ":name" => $userName,
    ":last_name" => $userLastName,
    ":user" => $userUser,
    ":key" => $userKey,
    ":email" => $userEmail
];

//aqui ejecutamos la query usando los marcadores.
$userSave->execute($markers);

if ($userSave->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Usuario Registrado!</strong><br>
            Usuario registrado con èxito.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor intentelo de nuevo.    
        </div>
    ';
}
$userSave = null;