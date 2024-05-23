<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Buscar usuario</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

    if (isset($_POST["search_module"])) {
        require_once "./php/search.php";

    }

    if (!isset($_SESSION['user_search']) && empty($_SESSION['user_search'])) {

        ?>

        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off">
                    <input type="hidden" name="search_module" value="user">
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_search" placeholder="¿Qué estas buscando?"
                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                        </p>
                        <p class="control">
                            <button class="button is-info" type="submit">Buscar</button>
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
                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                    <input type="hidden" name="search_module" value="user">
                    <input type="hidden" name="delete_search" value="user">
                    <p>Estas buscando <strong><?php echo $_SESSION['user_search']; ?></strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>
        <?php

        //ELIMINIUAR USUARIOS
        if (isset($_GET['user_id_del'])) {
            require_once './php/user_delete.php';
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
        $url = "index.php?view=user_search&page=";
        $regs = 15;
        $search = $_SESSION['user_search'];

        require_once "./php/user_list.php";
    }

    ?>
</div>