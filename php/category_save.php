<?php

require_once "main.php";

#almaenando datos
$categoryName = stringCleaner($_POST["category_name"]);
$categoryLocation = stringCleaner($_POST["category_location"]);

// verificando campos obligatorios
if ($categoryName == '') {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has rellenado todos los campos obligatorios.    
        </div>
        ';
    exit();
}

// Verificando integridad de los datos
if (dataVerify("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $categoryName)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato.    
        </div>
        ';
    exit();
}

if ($_POST['category_location'] != '') {
    if (dataVerify("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $categoryLocation)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                LA UBICACIÓN no coincide con el formato.    
            </div>
        ';
        exit();
    }
}

//VERIFICANDO QUE NO EXISTA EL NOMBRE EN LA BD
$checkName = conexion();
$checkName = $checkName->query("SELECT category_name FROM category WHERE category_name = '$categoryName'");

if ($checkName->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La CATEGORÍA ya existe en la base de datos.    
        </div>
    ';
    exit();
}
$checkUser = null;

//Guardando datos en la base de datos
$categorySave = conexion();
//Esta seria la query normal
//$userSave = $userSave->query("INSERT INTO user(user_name, user_last_name, user_user, user_key, user_email) VALUES ('$userName', '$userLastName', '$userUser', '$userKey', '$userEmail')");

//Esta seria preparar la query pero no ejecutarla, mejor para que no nos puedan inyectar codigo
$categorySave = $categorySave->prepare("INSERT INTO category(category_name, category_location) VALUES (:name, :location)");//en ved de colocar variables colocas marcadores usando los :

//Declaramos un array con los marcadores
$markers = [
    ":name" => $categoryName,
    ":location" => $categoryLocation
];

$categorySave->execute($markers);

if ($categorySave->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Categoría Registrada!</strong><br>
            Categoría registrada con éxito.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar la categoría, por favor intentelo de nuevo.    
        </div>
    ';
}
$categorySave = null;
