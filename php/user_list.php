<?php

$init = ($page > 0) ? (($regs * $page) - $regs) : 0;
$table = "";

if (isset($search) && $search != '') {
    $dataQuery = "SELECT * FROM user WHERE ((user_id !=  '" . $_SESSION['id'] . "') AND (user_name LIKE '%$search%' OR user_last_name LIKE '%$search%' OR user_user LIKE '%$search%' OR user_email LIKE '%$search%')) ORDER BY user_name ASC LIMIT  $init, $regs ;";

    $totalQuery = "SELECT count(user_id) FROM user WHERE  ((user_id != '" . $_SESSION['id'] . "') AND (user_name LIKE '%$search%' OR user_last_name LIKE '%$search%' OR user_user LIKE '%$search%' OR user_email LIKE '%$search%') );";
} else {
    $dataQuery = "SELECT * FROM user WHERE user_id != '" . $_SESSION['id'] . "'  ORDER BY user_name ASC LIMIT  $init, $regs ;";

    $totalQuery = "SELECT count(user_id) FROM user WHERE user_id != '" . $_SESSION['id'] . "';";
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
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Email</th>
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
            <td>' . $value['user_name'] . '</td>
            <td>' . $value['user_last_name'] . '</td>
            <td>' . $value['user_user'] . '</td>
            <td>' . $value['user_email'] . '</td>
            <td>
                <a href="index.php?view=user_update&user_id_up=' . $value['user_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
            </td>
            <td>
                <a href="' . $url . $page . '&user_id_del=' . $value['user_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
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
                    <td colspan="7">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
        ';
    } else {
        $table .= '
                <tr class="has-text-centered">
                    <td colspan="7">
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
        Mostrando usuarios <strong>' . $pagInit . '</strong> al <strong>' . $pagEnd . '</strong> de un <strong>total de ' . $nPages . '</strong>
    </p>
            ';
}



$conexion = null;
echo $table;
if ($total >= 1 && $nPages >= $page) {
    echo tablePager($page, $nPages, $url, 7);
}