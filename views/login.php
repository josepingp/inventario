<div class="main-container">

    <form action="" method="POST" class="box login" autocomplete="off">
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de invetario</h5>

        <div class="field">
            <label for="" class="label">Usuario</label>
            <div class="control">
                <input type="text" class="input" name="login_user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20"
                    required>
            </div>

            <div class="field">
                <label for="" class="label">Clave</label>
                <div class="control">
                    <input type="password" class="input" name="login_key" pattern="[a-zA-Z0-9$@.-]{7,100}"
                        maxlength="100" required>
                </div>
            </div>

            <p class="has-text-centered mb-4 mt-3">
                <button type="submit" class="button is-info is-rounded">Iniciar</button>
            </p>
        </div>

        <?php
            if ( isset($_POST['login_user']) && isset($_POST['login_key']) ) {
                require_once"./php/main.php";
                require_once"./php/session_start.php";

            }
        ?>
    </form>


</div>