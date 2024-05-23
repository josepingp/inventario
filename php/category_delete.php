<?php

$categoryIdDel = stringCleaner($_GET['category_id_del']);

//VERIFICANDO CATEGORIA
$categoryCheck = conexion();
$categoryCheck = $categoryCheck->query("SELECT category_id FROM category WHERE category_id = '$categoryIdDel';");

if ($categoryCheck->rowCount() == 1) {

    //VERIFICANDO SI CATEGORIA ESTA EN PRODUCTOS
    $categoryProductCheck = conexion();
    $categoryProductCheck = $categoryProductCheck->query("SELECT category_id FROM product WHERE category_id = '$categoryIdDel' LIMIT 1;");

    if ($categoryProductCheck->rowCount() <= 0) {
        $categoryDelete = conexion();
        $categoryDelete = $categoryDelete->prepare("DELETE FROM category WHERE category_id = :id;");

        $categoryDelete->execute([":id" => $categoryIdDel]);

        if ($categoryDelete->rowCount() == 1) {
            echo '
            <div class="notification is-info is-light">
                <strong>La categoía se elimino correctamente.</strong><br>
            </div>
        ';
        } else {
            echo '
        <div class="notification is-danger is-light">
            <strong>La categoría no se eliminó correctamente inténtelo de nuevo.</strong><br>
        </div>
    ';
    }
    $categoryDelete = null;
        
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>La categoría tiene productos registrados.</strong><br>
        </div>
    ';
    }

    $categoryProductCheck = null;
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>La categoría que intenta eliminar no existe.</strong><br>
        </div>
    ';
}
