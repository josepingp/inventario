<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Buscar producto</h2>
</div>

<div class="container pb-6 pt-6">
<?php
    require_once "./php/main.php";

    if (isset($_POST["search_module"])) {
        require_once "./php/search.php";
    }

    if (!isset($_SESSION['product_search']) && empty($_SESSION['product_search'])) {

        ?>

    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="search_module" value="product">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_search" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <?php
    } else {
        ?>

    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="search_module" value="product"> 
                <input type="hidden" name="delete_search" value="product">
                <p>Estas buscando <strong><?php echo $_SESSION['product_search']; ?></strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>

    <?php
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
$search = $_SESSION['product_search'];

require_once "./php/product_list.php";
}
?>
</div>