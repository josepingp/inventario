<?php

require_once "./main.php";
require_once "../inc/session_start.php";


#almaenando datos
$productCode = stringCleaner($_POST["product_code"]);
$productName = stringCleaner($_POST["product_name"]);
$productPrice = stringCleaner($_POST["product_price"]);
$productStock = stringCleaner($_POST["product_stock"]);
$productCategoryId = stringCleaner($_POST["product_category"]);

//Verificando campos obligatorios
if (
    $productCode == "" ||
    $productName == "" ||
    $productPrice == "" ||
    $productStock == "" ||
    $productCategoryId == ""
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
if (dataVerify("[a-zA-Z0-9- ]{1,70}", $productCode)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El código no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $productName)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[0-9.]{1,25}", $productPrice)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El precio no coincide con el formato.    
        </div>
        ';
    exit();
}

if (dataVerify("[0-9]{1,25}", $productStock)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El stock no coincide con el formato.    
        </div>
        ';
    exit();
}

//Verificando los datos
//Validando el codigo del producto
$checkProductCode = conexion();
$checkProductCode = $checkProductCode->query("SELECT product_code FROM product WHERE product_code = '$productCode'");

if ($checkProductCode->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El codigo de producto ya existe en la base de datos.    
        </div>
    ';
    exit();
}
$checkProductCode = null;

//Validando el nombre del producto
$checkProductName = conexion();
$checkProductName = $checkProductName->query("SELECT product_name FROM product WHERE product_name = '$productName'");

if ($checkProductName->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre del producto ya existe en la base de datos.    
        </div>
    ';
    exit();
}
$checkProductName = null;

//Validando categoría del producto
$checkProductCategory = conexion();
$checkProductCategory = $checkProductCategory->query("SELECT category_id FROM category WHERE category_id = '$productCategoryId'");

if ($checkProductCategory->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La categoría no existe en nuestra base de datos.    
        </div>
    ';
    exit();
}
$checkProductCategory = null;

//Directorio de imagenes
$imgDir = "../img/product/";

//Comprobar si se selcciono una imagen
if ($_FILES['product_photo']['name'] != '' && $_FILES['product_photo']['size'] > 0) {

    //Verificando el directotio y si no lo creamos
    if (!file_exists($imgDir)) {
        if (!mkdir($imgDir)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al crear el directorio.    
                </div>
    ';
            exit();
        }
    }
    //Verificando formato de imágenes
    if (
        mime_content_type($_FILES['product_photo']['tmp_name']) != "image/jpeg" &&
        mime_content_type($_FILES['product_photo']['tmp_name']) != "image/png"
    ) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen tiene un formato erroneo.    
                </div>
            ';
        exit();
    }

    //Verificando peso de la imagen
    if ($_FILES['product_photo']['size'] / 1024 > 3072) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen supera el peso permitido.    
            </div>
    ';
        exit();
    }

    //Extension de la imagen
    switch (mime_content_type($_FILES['product_photo']['tmp_name'])) {
        case "image/jpeg":
            $imgExtension = ".jpeg";
            break;
        case "image/png":
            $imgExtension = ".png";
            break;
    }
    //Le damos permisos de lectura y escritura al directorio
    chmod($imgDir,0777);

    $imgName = renamePhoto($productName);

    $productPhoto = $imgName . $imgExtension;

    //Moviendo imagen al directorio
    if (!move_uploaded_file($_FILES['product_photo']['tmp_name'], $imgDir.$productPhoto)) {

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen no se pudo cargar correctamente.    
            </div>
        ';
        exit();
    }
} else {
    $productPhoto = '';
}

$productSave = conexion();
$productSave = $productSave->prepare("INSERT INTO product(product_code, product_name, product_price, product_stock, product_photo, category_id, user_id) VALUES (:code, :name, :price, :stock, :photo, :category, :user)");

$markers = [
    ":code"=> $productCode,
    ":name"=> $productName,
    ":price"=> $productPrice,
    ":stock"=> $productStock,
    ":photo"=> $productPhoto,
    ":category"=> $productCategoryId,
    ":user"=> $_SESSION['id']
];

$productSave->execute($markers);

if ($productSave->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Producto Registrado!</strong><br>
            Producto registrado con èxito.
        </div>
    ';
} else {
    if (is_file($imgDir.$productPhoto)) {
        chmod($imgDir.$productPhoto, 0777);
        unlink($imgDir.$productPhoto);
    }
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el producto, por favor intentelo de nuevo.    
        </div>
    ';
}
$productSave = null;

