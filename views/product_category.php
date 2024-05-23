<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>
<?php
require_once "./php/main.php";
?>
<div class="container pb-6 pt-6">
    <div class="columns">



        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
            <?php
            $categories = conexion();
            $categories = $categories->query("SELECT * FROM category");

            if ($categories->rowCount() > 0) {
                $categories = $categories->fetchAll();

                foreach ($categories as $category) {
                    echo '<a href="index.php?view=product_category&category_id=' . $category['category_id'] . '" class="button  is-fullwidth is-hoverable">' . $category['category_name'] . '</a>';
                }
            } else {
                echo '<p class="has-text-centered">No hay categorías registradas</p>';

            }
            $categories = null;
            ?>
        </div>



        <div class="column">
            <?php
            $categoryId = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

            $category = conexion();
            $category = $category->query("SELECT * FROM category WHERE category_id = " . $categoryId);

            if ($category->rowCount() > 0) {
                $category = $category->fetch();
                echo '
                        <h2 class="title has-text-centered">' . $category['category_name'] . '</h2>
                        <p class="has-text-centered pb-6">' . $category['category_location'] . '</p>
                    ';
                
                //ELIMINIUAR PRODUCTOS
            if (isset($_GET['product_id_del'])) {
                require_once "./php/product_delete.php";
            }
            
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = (int) $_GET['page'];
                if ($page <= 1) {
                    $page = 1;
                }
            }

            $page = stringCleaner($page);
            $url = "index.php?view=product_category&category_id=$categoryId&page=";
            $regs = 15;
            $search = "";
        
            require_once "./php/product_list.php";

            } else {
                echo '<h2 class="has-text-centered title">Seleccione una categoría para empezar</h2>';
            }
            $category = null;
            ?>

        </div>

    </div>
</div>