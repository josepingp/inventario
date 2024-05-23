<?php
require_once "main.php";

$id = stringCleaner($_POST["category_id"]);

//VERIFICANDO CATEGOÍA

$categoryCheck = conexion();
$categoryCheck = $categoryCheck->query("SELECT * FROM category where category_id = '$id'");

if ($categoryCheck->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La categoría no existe en el sistema.
        </div>
    ';
    exit();
} else {
    $data = $categoryCheck->fetch();
}

$categoryCheck = null;

//ALMACENANDO DATOS
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
if ($categoryName != $data['category_name']) {
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
    $checkName = null;
}

//Guardando datos en la base de datos
$categoryUpdate = conexion();

$categoryUpdate = $categoryUpdate->prepare("UPDATE category SET category_name = :name, category_location = :location WHERE category_id = :id");//en ved de colocar variables colocas marcadores usando los :

//Declaramos un array con los marcadores
$markers = [
    ":name" => $categoryName,
    ":location" => $categoryLocation,
    ":id" => $id
];

$categoryUpdate->execute($markers);

if ($categoryUpdate->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Categoría Actualizada!</strong><br>
            Categoría actualizada con éxito.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar la categoría, por favor intentelo de nuevo.    
        </div>
    ';
}
$categoryUpdate = null;
