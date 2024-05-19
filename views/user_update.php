<?php
require_once './php/main.php';

$id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
$id = stringCleaner($id);
?>

<div class="container is-fluid mb-6">
    <?php
    if ($id == $_SESSION['id']) {
        ?>
        <h1 class="title">Mi cuenta</h1>
        <h2 class="subtitle">Actualizar datos de cuenta</h2>
        <?php
    } else {
        ?>
        <h1 class="title">Usuarios</h1>
        <h2 class="subtitle">Actualizar usuario</h2>
        <?php
    }
    ?>
</div>

<div class="container pb-6 pt-6">

    <?php
    
    require_once './inc/back_btn.php';

    $userCheck = conexion();
    $userCheck = $userCheck->query("SELECT * FROM user WHERE user_id = '$id';");
    

    if ($userCheck->rowCount() > 0) {
        $data = $userCheck->fetch();
    ?>

<div class="form-rest mb-6 mt-6"></div>

    <form action="./php/user_update.php" method="POST" class="ajax_form" autocomplete="off">

        <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?>" required>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="user_name" value="<?php echo $data['user_name'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                        maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="user_last_name" value="<?php echo $data['user_last_name'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                        maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="user_user" value="<?php echo $data['user_user'] ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20"
                        required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="user_email" value="<?php echo $data['user_email'] ?>" maxlength="70">
                </div>
            </div>
        </div>
        <br><br>
        <p class="has-text-centered">
            SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave
            deje los campos vacíos.
        </p>
        <br>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="user_key_1" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="100">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Repetir clave</label>
                    <input class="input" type="password" name="user_key_2" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="100">
                </div>
            </div>
        </div>
        <br><br><br>
        <p class="has-text-centered">
            Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado
            sesión
        </p>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="user_admin" pattern="[a-zA-Z0-9]{4,20}"
                        maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="key_admin" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>

    <?php 
    } else {
        require_once "./inc/error_banner.php";
    }
    $userCheck = null;
    ?>
</div>