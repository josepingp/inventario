<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id = stringCleaner($_POST["user_id"]);

//VERIFICANDO USUARIO

$userCheck = conexion();
$userCheck = $userCheck->query("SELECT * FROM user where user_id = '$id'");

if ($userCheck->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario no existe en el sistema.
        </div>
    ';
    exit();
} else {
    $data = $userCheck->fetch();
}
$userCheck = null;

$adminUser = stringCleaner($_POST['user_admin']);
$adminKey = stringCleaner($_POST['key_admin']);

//VERIFICANDO CAMOPOS OBLIGATORIOS
if ($adminUser == '' || $adminKey == '') {
    echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Debe rellenar los campos obligatorios Usuario/Clave.
        </div>
    ';
    exit();
} else {
    //VERIFICANDO INTEGRIDAD DE LOS DATOS
    if (dataVerify("[a-zA-Z0-9]{4,20}", $adminUser)) {
        echo '
            <div class="notification is-danger is-light mb-6 mt-6">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su usuario no coincide con el formato solicitado.
            </div>
    ';
        exit();
    }

    if (dataVerify("[a-zA-Z0-9$@.-]{7,100}", $adminKey)) {
        echo '
            <div class="notification is-danger is-light mb-6 mt-6">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su clave no coincide con el formato solicitado.
            </div>
    ';
        exit();
    }

    $checkAdmin = conexion();
    $checkAdmin = $checkAdmin->query("SELECT user_user, user_key FROM user WHERE user_user = '$adminUser' AND user_id ='" . $_SESSION['id'] . "';");

    if ($checkAdmin->rowCount() == 1) {

        $checkAdmin = $checkAdmin->fetch();

        if ($checkAdmin['user_user'] != $adminUser || !password_verify($adminKey, $checkAdmin['user_key'])) {
            echo '
                <div class="notification is-danger is-light mb-6 mt-6">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario o clave incorrectos.
                </div>
    ';
            exit();
        }

    } else {
        echo '
            <div class="notification is-danger is-light mb-6 mt-6">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos.
            </div>
    ';
        exit();
    }
}
$checkAdmin = null;

//ALMACENANDO DATOS
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
    $userUser == ''
) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has rellenado todos los campos obligatorios.    
        </div>
        ';
    exit();
}

//VERIFICANDO INTEGRIDAD DE LOS DATOS
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

//VERIFICANDO MAIL
if ($userEmail != '' && $userEmail != $data['user_email']) {

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

//VERIFICANDO USUARIO
if ($data['user_user'] != $userUser) {
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
}

//VERIFICANDO CLAVES
if ($userKey1 != '' || $userKey2 != '') {
    //VERIFICANDO INTEGRIDAD DE LA CLAVE
    if (dataVerify("[a-zA-Z0-9$@.-]{7,100}", $userKey1) || dataVerify("[a-zA-Z0-9$@.-]{7,100}", $userKey2)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las Claves no coincide con el formato.    
            </div>
            ';
        exit();
    } else {
        //VERIFICO QUE LAS CLAVES SEAN IGUALES
        if ($userKey1 != $userKey2) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Las claves no coinciden.    
                </div>
            ';
            exit();
        } else {
            //GUARDO LA CLAVE NUEVA HASHEADA
            $userKey = password_hash($userKey1, PASSWORD_BCRYPT, ["cost" => 10]);
        }
    }
} else {
    $userKey = $data['user_key'];
}

//ACTUALIZAR DATOS
$userUpdate = conexion();
$userUpdate = $userUpdate->prepare("UPDATE user SET user_name = :name, user_last_name = :last_name, user_user = :user, user_key = :key, user_email = :email WHERE user_id = :id ");

$markers = [
    ":name" => $userName,
    ":last_name" => $userLastName,
    ":user" => $userUser,
    ":key" => $userKey,
    ":email" => $userEmail,
    ":id" => $id
];

if ($userUpdate->execute($markers)) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Usuario actualizado!</strong><br>
            El usuario se actualizó con éxito.    
        </div>
';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se ha podido llevar a cabo la actualización.    
        </div>
';
}
$userUpdate = null;
