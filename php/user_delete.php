<?php
$userIdDel = stringCleaner($_GET['user_id_del']);

//VERIFICANDO USUARIO
$userCheck = conexion();
$userCheck = $userCheck->query("SELECT user_id FROM user WHERE user_id = '$userIdDel';");

if ($userCheck->rowCount() == 1) {

    //VERIFICANDO SI USUARIO ESTA EN PRODUCTOS
    $userProductCheck = conexion();
    $userProductCheck = $userProductCheck->query("SELECT user_id FROM product WHERE user_id = '$userIdDel' LIMIT 1;");

    if ($userProductCheck->rowCount() <= 0) {
        $userDelete = conexion();
        $userDelete = $userDelete->prepare("DELETE  FROM user WHERE user_id = :id;");

        $userDelete->execute([":id" => $userIdDel]);

        if ($userDelete->rowCount() == 1) {
            echo '
            <div class="notification is-info is-light">
                <strong>Los datos del usuario se eliminaron correctamente.</strong><br>
            </div>
        ';
        } else {
            echo '
        <div class="notification is-danger is-light">
            <strong>El usuario no se eliminó correctamente inténtelo de nuevo.</strong><br>
        </div>
    ';
    }
    $userDelete = null;
        
        

    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>El usuario tiene productos registrados.</strong><br>
        </div>
    ';
    }

    $userProductCheck = null;
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>El usuario que intenta eliminar no existe.</strong><br>
        </div>
    ';
}