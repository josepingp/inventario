<?php

$init = ($page > 0) ? (($regs * $page) - $regs) : 0;

$table = '';

$colums = "product.product_id, product.product_code, product.product_name, product.product_price, product.product_stock, product.product_photo, category.category_name, user.user_name, user.user_last_name";

if (isset($search) && $search != '') {
    $dataQuery = "SELECT $colums FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN user ON product.user_id = user.user_id WHERE product.product_code LIKE '%$search%' OR product.product_name LIKE '%$search%' ORDER BY product.product_name ASC LIMIT  $init, $regs;";

    $totalQuery = "SELECT count(product_id) FROM product WHERE product_name LIKE '%$search%' OR product_code LIKE '%$search%';";

} elseif ($categoryId > 0) {
    $dataQuery = "SELECT $colums FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN user ON product.user_id = user.user_id WHERE product.category_id = $categoryId";

    $totalQuery = "SELECT count(product_id) FROM product WHERE category_id =" . $categoryId;

} else {
    $dataQuery = "SELECT $colums FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN user ON product.user_id = user.user_id ORDER BY product.product_name ASC LIMIT  $init, $regs ;";

    $totalQuery = "SELECT count(product_id) FROM product;";
}

$conexion = conexion();

$data = $conexion->query($dataQuery);
$data = $data->fetchAll();

$total = $conexion->query($totalQuery);
$total = (int) $total->fetchColumn();


$nPages = ceil($total / $regs);

if ($total >= 1 && $nPages >= $page) {
    $counter = $init + 1;
    $pagInit = $init + 1;
    foreach ($data as $key => $value) {
        $table .= '
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">';
        if (is_file("./img/product/" . $value['product_photo'])) {
            $table .= '<img src="./img/product/' . $value['product_photo'] . '">';
        } else {
            $table .= '<img src="./img/product/product.png">';
        }

        $table .= '</p>
                        </figure>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>' . $counter . '- ' . $value['product_name'] . '</strong><br>
                                    <strong>CODIGO:</strong> ' . $value['product_code'] . ', 
                                    <strong>PRECIO:</strong> ' . $value['product_price'] . ', 
                                    <strong>STOCK:</strong> ' . $value['product_stock'] . ', 
                                    <strong>CATEGORIA:</strong> ' . $value['category_name'] . ', 
                                    <strong>REGISTRADO POR:</strong> ' . $value['user_name'] . ' ' . $value['user_last_name'] . '
                            </div>
                            <div class="has-text-right">
                                <a href="index.php?view=product_img&product_id_up=' . $value['product_id'] . '" class="button is-link is-rounded is-small">Imagen</a>
                                
                                <a href="index.php?view=product_update&product_id_up=' . $value['product_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                                
                                <a href="' . $url . $page . '&product_id_del=' . $value['product_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                            </div>
                        </div>
                    </article>
                ';
        $counter++;
    }
    $pagEnd = $counter - 1;

} else {
    if ($total >= 1) {
        $table .= '
        <p class="has-text-centered">
                <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </p>
        ';
    } else {
        $table .= '
            <p class="has-text-centered">No hay registros en el sistema</p>
        ';
    }

}

if ($total >= 1 && $page <= $nPages) {
    $table .= '
        <p class="has-text-right">
            Mostrando productos <strong>' . $pagInit . '</strong> al <strong>' . $pagEnd . '</strong> de un <strong>total de ' . $nPages . '</strong>
        </p>
    ';
}

$conexion = null;
echo $table;
if ($total >= 1 && $nPages >= $page) {
    echo tablePager($page, $nPages, $url, 4);
}