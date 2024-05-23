<?php
require_once "main.php";

$productId = stringCleaner($_POST["img_up_id"]);

//VERIFICANDO PRODUCTO
$productCheck = conexion();
$productCheck = $productCheck->query("SELECT * FROM product where product_id =" . $productId);

if ($productCheck->rowCount() == 1) {
    $data = $productCheck->fetch();
} else {
    echo '
        <div class="notification is-danger is-light mb-6 mt-6">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La imagen del producto no existe en el sistema.
        </div>
    ';
    exit();
}
$productCheck = null;
//Directorio de imagenes
$imgDir = "../img/product/";

//Comprobar si se selcciono una imagen
if ($_FILES['product_photo']['name'] == '' || $_FILES['product_photo']['size'] == 0) {
    echo '
    <div class="notification is-danger is-light mb-6 mt-6">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No ha seleccionado ninguna imagen válida..
        </div>
        ';
        exit();
    }
    
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

//Le damos permisos de lectura y escritura al directorio
chmod($imgDir, 0777);

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
    
    $imgName = renamePhoto($data['product_name']);
    $imgNamePhoto = $imgName . $imgExtension;
    
    
    if (!move_uploaded_file($_FILES['product_photo']['tmp_name'], $imgDir . $imgNamePhoto)) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La imagen no se pudo cargar correctamente.    
        </div>
        ';
        exit();
    }

    var_dump($data);
    if (is_file($imgDir . $data['product_photo']) && $data['product_photo'] != $imgNamePhoto) {
        chmod($imgDir . $data['product_photo'], 0777);
        unlink($imgDir . $data['product_photo']);
    }

    $productUpdate = conexion();
    $productUpdate = $productUpdate->prepare("UPDATE product SET product_photo = :photo WHERE product_id = :id");//en ved de colocar variables colocas marcadores usando los :
    
$markers = [
    ":photo" => $imgNamePhoto,
    ":id" => $productId
];
$productUpdate->execute($markers);


if ($productUpdate->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Imagen o foto actualizada!</strong><br>
            La imagen se actualizo con éxito, pulse aceptar para recargar los cambios.
        </div>

        <p class="has-text-centered pt-5 pb-5">
                <a class="button is-link is-rounded" href="index.php?view=product_img&product_id_up=' . $productId . '">Aceptar</a>
        </p>
    ';
} else {

    if (is_file($imgDir . $imgNamePhoto)) {
        chmod($imgDir . $imgNamePhoto, 0777);
        unlink($imgDir . $imgNamePhoto);
    }

    echo '
        <div class="notification is-danger is-light">
            <strong>¡Imagen o foto eliminada!</strong><br>
            Hubo algun problema, por favor intentelo de nuevo.
        </div>
    ';
}
$productUpdate = null;
