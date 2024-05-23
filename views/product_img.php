<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Actualizar imagen de producto</h2>
</div>

<div class="container pb-6 pt-6">

    <p class="has-text-right pt-4 pb-4">
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

        <div class="columns">

            <div class="column is-two-fifths">
                <?php if (is_file("./img/product/" . $data['product_photo'])) { ?>
                    <figure class="image mb-6">
                        <img src="./img/product/<?php echo $data['product_photo']; ?>">
                    </figure>

                    <form class="ajax_form" action="./php/product_img_delete.php" method="POST" autocomplete="off">

                        <input type="hidden" name="img_del_id" value="<?php echo $data['product_id']; ?>">

                        <p class="has-text-centered">
                            <button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
                        </p>
                    </form>
                <?php } else { ?>

                    <figure class="image mb-6">
                        <img src="./img/product/product.png">
                    </figure>

                <?php } ?>
            </div>

            <div class="column">
                <form class="mb-6 has-text-centered ajax_form" action="./php/product_img_update.php" method="POST" enctype="multipart/form-data"
                    autocomplete="off">

                    <h4 class="title is-4 mb-6"><?php echo $data['product_name']; ?></h4>

                    <label>Foto o imagen del producto</label><br>

                    <input type="hidden" name="img_up_id" value="<?php echo $data['product_id']; ?>">

                    <div class="file has-name is-horizontal is-justify-content-center mb-6">
                        <label class="file-label">
                            <input class="file-input" type="file" name="product_photo" accept=".jpg, .png, .jpeg">
                            <span class="file-cta">
                                <span class="file-label">Imagen</span>
                            </span>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </label>
                    </div>

                    <p class="has-text-centered">
                        <button type="submit" class="button is-success is-rounded">Actualizar</button>
                    </p>
                </form>

            </div>

        </div>

        <?php
        } else {
            include_once "./inc/error_banner.php";
        }
        ?>

</div>