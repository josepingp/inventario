<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Nuevo producto</h2>
</div>
<?php
require_once "./php/main.php";
?>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/product_save.php" method="POST" class="ajax_form" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Código de barra</label>
                    <input class="input" type="text" name="product_code" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70"
                        required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="product_name"
                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="text" name="product_price" pattern="[0-9.]{1,25}" maxlength="25"
                        required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Stock</label>
                    <input class="input" type="text" name="product_stock" pattern="[0-9]{1,25}" maxlength="25"
                        required>
                </div>
            </div>
            <div class="column">
                <label>Categoría</label><br>
                <div class="select is-rounded">
                    <select name="product_category">
                        <option value="" selected="">Seleccione una opción</option>

                        <?php
                        $categories = conexion();
                        $categories = $categories->query("SELECT * FROM category");

                        if ($categories->rowCount() > 0) {
                            $categories = $categories->fetchAll();

                            foreach ($categories as $category) {
                                echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
                            }
                        }
                        $categories = null;
                        ?>

                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <label>Foto o imagen del producto</label><br>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="product_photo" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            <span class="file-label">Imagen</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                    </label>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>