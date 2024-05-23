<?php

$productIdDel = stringCleaner($_GET['product_id_del']);

//VERIFICANDO CATEGORIA
$productCheck = conexion();
$productCheck = $productCheck->query("SELECT * FROM product WHERE product_id = '$productIdDel';");

if ($productCheck->rowCount() == 1) {
    $data = $productCheck->fetch();
    $productDelete = conexion();
    $productDelete = $productDelete->prepare("DELETE FROM product WHERE product_id = :id;");

    $productDelete->execute([":id" => $productIdDel]);

    if ($productDelete->rowCount() == 1) {
        if (is_file("./img/product/" . $data['product_photo'])) {
            echo "hola";
            chmod("./img/product/" . $data['product_photo'], 0777);
            unlink("./img/product/" . $data['product_photo']);
        }
            echo '
            <div class="notification is-info is-light">
                <strong>El producto se elimino correctamente.</strong><br>
            </div>
        ';
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>El producto no se eliminó correctamente inténtelo de nuevo.</strong><br>
        </div>
    ';
    }
    $productDelete = null;

} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>El producto que intenta eliminar no existe.</strong><br>
        </div>
    ';
}
$productCheck = null;
