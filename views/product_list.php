<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">
<?php
    require_once "./php/main.php";

    //ELIMINIUAR PRODUCTOS
    if(isset($_GET['product_id_del'])) {
        require_once "./php/product_delete.php";
    }

    $categoryId = (isset($categoryId)) ? $_GET['category_id'] : 0;

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = (int) $_GET['page'];
        if ($page <= 1) {
            $page = 1;
        }
    }
    $page = stringCleaner($page);
    $url = "index.php?view=product_list&page=";
    $regs = 15;
    $search = "";

    require_once "./php/product_list.php";
    ?>
</div>