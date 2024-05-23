<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Actualizar producto</h2>
</div>

<div class="container pb-6 pt-6">

    <?php

    require_once './php/main.php';

    $id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;
    $id = stringCleaner($id);

    require_once './inc/back_btn.php';
    
    $productCheck = conexion();
    $productCheck = $productCheck->query("SELECT * FROM product WHERE product_id = '$id';");
    
    
    if ($productCheck->rowCount() > 0) {
        $data = $productCheck->fetch();
        ?>

        <div class="form-rest mb-6 mt-6"></div>

        <h2 class="title has-text-centered"><?php echo $data['product_name']; ?></h2>

        <form action="./php/product_update.php" method="POST" class="ajax_form" autocomplete="off">

            <input type="hidden" name="product_id" required value="<?php echo $data['product_id']; ?>">

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Código de barra</label>
                        <input class="input" type="text" name="product_code" value="<?php echo $data['product_code']; ?>"
                            pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Nombre</label>
                        <input class="input" type="text" name="product_name" value="<?php echo $data['product_name']; ?>"
                            pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Precio</label>
                        <input class="input" type="text" name="product_price" value="<?php echo $data['product_price']; ?>"
                            pattern="[0-9.]{1,25}" maxlength="25" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Stock</label>
                        <input class="input" type="text" name="product_stock" value="<?php echo $data['product_stock']; ?>"
                            pattern="[0-9]{1,25}" maxlength="25" required>
                    </div>
                </div>
                <div class="column">
                    <label>Categoría</label><br>
                    <div class="select is-rounded">
                        <select name="category_id">
                            <?php
                            $categories = conexion();
                            $categories = $categories->query("SELECT * FROM category");

                            if ($categories->rowCount() > 0) {
                                $categories = $categories->fetchAll();

                                foreach ($categories as $category) {
                                    if ($data['category_id'] == $category['category_id']) {    
                                        echo '<option value="' . $category['category_id'] . '" selected="">' . $category['category_name'] . '(Actual)</option>';
                                    } else {
                                        echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
                                    }
                                }

                            }
                            $categories = null;
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-success is-rounded">Actualizar</button>
            </p>
        </form>
        <?php
    } else {
        include_once "./inc/error_banner.php";
    }
    ?>

</div>