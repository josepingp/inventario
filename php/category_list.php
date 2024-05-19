<?php

$init = ($page > 0) ? (($regs * $page) - $regs) : 0;
$table = "";

if (isset($search) && $search != '') {
    $dataQuery = "SELECT * FROM category WHERE category_name LIKE '%$search%' OR category_location LIKE '%$search%' ORDER BY category_name ASC LIMIT  $init, $regs ;";

    $totalQuery = "SELECT count(category_id) FROM category WHERE category_name LIKE '%$search%' OR category_location LIKE '%$search%';";
} else {
    $dataQuery = "SELECT * FROM category ORDER BY category_name ASC LIMIT  $init, $regs ;";

    $totalQuery = "SELECT count(category_id) FROM category;";
}

$conexion = conexion();

$data = $conexion->query($dataQuery);
$data = $data->fetchAll();

$total = $conexion->query($totalQuery);
$total = (int) $total->fetchColumn();

$nPages = ceil($total / $regs);

$table .= '
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Productos</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody class="has-text-centered">
        ';

if ($total >= 1 && $nPages >= $page) {
    $counter = $init + 1;
    $pagInit = $init + 1;
    foreach ($data as $key => $value) {
        $table .= '
        <tr class="has-text-centered">
            <td>' . $counter . '</td>
            <td>' . $value['category_name'] . '</td>
            <td>' . substr($value['category_location'], 0, 30) . '</td>
            <td>
                <a href="index.php?view=product_category&category_id=' . $value['category_id'] . '" class="button is-link is-rounded is-small">Ver productos</a>
            </td>
            <td>
                <a href="index.php?view=category_update&category_id_up=' . $value['category_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
            </td>
            <td>
                <a href="' . $url . $page . '&category_id_del=' . $value['category_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
            </td>
        </tr>
        ';
        $counter++;
    }
    $pagEnd = $counter - 1;
    
} else {
    if ($total >= 1) {
        $table .= '
                <tr class="has-text-centered">
                    <td colspan="6">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
        ';
    } else {
        $table .= '
                <tr class="has-text-centered">
                    <td colspan="6">
                        No hay registros en el sistema
                    </td>
                </tr>
        ';
    }
    
}
$table .= ' 
    </tbody>
    </table>
    </div>
';

if ($total >= 1 && $page <= $nPages  ) {
    $table .= '
    <p class="has-text-right">
        Mostrando categorías <strong>' . $pagInit . '</strong> al <strong>' . $pagEnd . '</strong> de un <strong>total de ' . $nPages . '</strong>
    </p>
            ';
}

$conexion = null;
echo $table;
if ($total >= 1 && $nPages >= $page) {
    echo tablePager($page, $nPages, $url, 4);
}