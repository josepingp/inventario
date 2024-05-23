<?php
require_once "main.php";

$id = stringCleaner($_POST["product_id"]);

//VERIFICANDO PRODUCTO
$productCheck = conexion();
$productCheck = $productCheck->query("SELECT * FROM product where product_id =" . $id);

if ($productCheck->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light mb-6 mt-6">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El producto no existe en el sistema.
        </div>
    ';
    exit();
} else {
    $data = $productCheck->fetch();
}
$productCheck = null;



#almaenando datos
$productCode = stringCleaner($_POST["product_code"]);
$productName = stringCleaner($_POST["product_name"]);
$productPrice = stringCleaner($_POST["product_price"]);
$productStock = stringCleaner($_POST["product_stock"]);
$productCategoryId = stringCleaner($_POST["category_id"]);

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

if ($productCode != $data['product_code']) {
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
}

if ($productName != $data['product_name']) {
    //Validando el nombre del producto
    $checkProductName = conexion();
    $checkProductName = $checkProductName->query("SELECT product_name FROM product WHERE product_name = '" . $productName . "'");
    
    echo $productName;
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
}

//Validando categoría del producto
if ($productCategoryId !=  $data['category_id']) {
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
}

//Guardando datos en la base de datos
$productUpdate = conexion();

$productUpdate = $productUpdate->prepare("UPDATE product SET product_code = :code, product_name = :name, product_price = :price, product_stock = :stock, category_id = :category WHERE product_id = :id");//en ved de colocar variables colocas marcadores usando los :

//Declaramos un array con los marcadores
$markers = [
    ":code" => $productCode,
    ":name" => $productName,
    ":price" => $productPrice,
    ":stock" => $productStock,
    ":category" => $productCategoryId,
    ":id" => $id
];

$productUpdate->execute($markers);

if ($productUpdate->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Producto Actualizado!</strong><br>
            Producto actualizado con éxito.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar el producto, por favor intentelo de nuevo.    
        </div>
    ';
}
$productUpdate = null;
