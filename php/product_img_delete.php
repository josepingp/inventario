<?php
require_once "main.php";

$productId = stringCleaner($_POST["img_del_id"]);

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

//Le damos permisos de lectura y escritura al directorio

if (is_file($imgDir . $data['product_photo'])) {
    chmod($imgDir . $data['product_photo'], 0777);

    if (!unlink($imgDir . $data['product_photo'])) {
        echo '
            <div class="notification is-danger is-light mb-6 mt-6">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen del producto no se pudo eliminar, inténtelo de nuevo
                mas tarde.
            </div>
    ';
        exit();
    }

}

$productUpdate = conexion();

$productUpdate = $productUpdate->prepare("UPDATE product SET product_photo = :photo WHERE product_id = :id");//en ved de colocar variables colocas marcadores usando los :

$markers = [
    ":photo" => "",
    ":id" => $productId
];
$productUpdate->execute($markers);

if ($productUpdate->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡Imagen o foto eliminada!</strong><br>
            La imagen se elimino con éxito, pulse aceptar para recargar los cambios.
        </div>

        <p class="has-text-centered pt-5 pb-5">
                <a class="button is-link is-rounded" href="index.php?view=product_img&product_id_up=' . $productId . '">Aceptar</a>
        </p>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Imagen o foto eliminada!</strong><br>
            Hubo algun problema, pulse aceptar para recargar los cambios.
            
            <p class="has-text-centered pt-5 pb-5">
                <a class="button is-link is-rounded" href="index.php?view=product_img&product_id_up=' . $productId . '">Aceptar</a>
            </p>
        </div>
    ';
}
$productUpdate = null;




