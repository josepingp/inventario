<?php

$searchModule = stringCleaner($_POST['search_module']);

$modules = ['user', 'category', 'product'];



if (in_array($searchModule, $modules)) {
    $urlModules = [
        "user" => "user_search",
        "category" => "category_search",
        "product" => "product_search"
    ];

    $urlModules = $urlModules[$searchModule];

    $searchModule = $searchModule . "_search";

    //INICIANDO BUSQUEDA
    if (isset($_POST["txt_search"])) {
        $txt = stringCleaner($_POST["txt_search"]);

        if ($txt === '') {
            echo '
            <div class="notification is-danger is-light">
                <strong>Introduzca un término de busqueda.</strong><br>
            </div>
        ';
        } else {
            if (dataVerify("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $txt)) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>El término de busqueda no coincide con el formato solicitado.</strong><br>
                </div>
            ';
            } else {
                $_SESSION[$searchModule] = $txt;
                header("Location: index.php?view=$urlModules", true, 303);
                exit();
            }

        }


    }

    //ELIMINAR LA BUSQUEDA
    if (isset($_POST["delete_search"])) {
        unset($_SESSION['user_search']);
    }

} else {
    echo '
    <div class="notification is-danger is-light">
        <strong>No podemos procesar la petición.</strong><br>
    </div>
';
}
