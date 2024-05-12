<?php

//Conexion a la base de datos
function conexion()
{
    $pdo = new PDO('mysql:host=localhost;dbname=inventory', 'root', '');
    return $pdo;
}


// verificar datos
function dataVerify($filter, string $string): bool
{
    if (preg_match("/^" . $filter . "$/", $string)) {
        return false;
    } else {
        return true;
    }
}

// Limpiar cadenas de texto para evitar inyeccion sql
function stringCleaner(string $string): string
{
    $string = trim($string);
    $string = stripcslashes($string);
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("</script src", "", $string);
    $string = str_ireplace("</script type=", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("DROP DATABASE", "", $string);
    $string = str_ireplace("TRUNCATE TABLE", "", $string);
    $string = str_ireplace("SHOW TABLES", "", $string);
    $string = str_ireplace("SHOW DATABASES", "", $string);
    $string = str_ireplace("<?php", "", $string);
    $string = str_ireplace("?>", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("<", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    $string = str_ireplace(";", "", $string);
    $string = str_ireplace("::", "", $string);
    $string = trim($string);
    $string = stripcslashes($string);
    return $string;
}

//Renombrar las fotos
function renamePhoto(string $photoName): string
{
    $photoName = str_ireplace(" ", "_", $photoName);
    $photoName = str_ireplace("/", "_", $photoName);
    $photoName = str_ireplace("#", "_", $photoName);
    $photoName = str_ireplace("-", "_", $photoName);
    $photoName = str_ireplace("$", "_", $photoName);
    $photoName = str_ireplace(".", "_", $photoName);
    $photoName = str_ireplace(",", "_", $photoName);
    $photoName = $photoName . "_" . rand(0, 100);//le pongo un numero aleatorio por si dos fotos se llaman igual
    return $photoName;
}

//FUNCION PAGINADOR DE TABLAS

function tablePager(int $actualPage, int $nPages, string $url, int $buttons)
{
    $table = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

    if ($actualPage <= 1) {
        
        $table .= '
        <a class="pagination-previous is-disabled" disabled>Anterior</a>
        <ul class="pagination-list">
        ';

    } else {
        
        $table .= '
        <a href="' . $url . ($actualPage - 1) . '" class="pagination-previous">Anterior</a>
        <ul class="pagination-list">
            <li><a href="' . $url . '1" class="pagination-link">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
        ';

    }

    $iterationCounter = 0;

    for ($i=$actualPage; $i <= $nPages; $i++) { 
        
        if($iterationCounter >= $buttons){
            break;
        }
        
        if ($actualPage == $i) {
            $table .= '<li><a href="' . $url . $i . '" class="pagination-link">' . $i . '</a></li>';
        } else {
            $table .= '<li><a href="' . $url . $i . '" class="pagination-link">' . $i . '</a></li>';
        }

        $iterationCounter++;
    }


    if ($actualPage == $nPages) {
        $table .= '
        </ul>
        <a class="pagination-next is-disabled" disabled>Siguiente</a>
        ';
    } else {
        $table .= '
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a href="' . $url . $nPages . '" class="pagination-link">' . $nPages . '</a></li>
        </ul>
        <a href="' . $url . ($actualPage + 1) . '" class="pagination-next">Siguiente</a>
        ';
    }

    $table .= '</nav>';
    return $table;
}