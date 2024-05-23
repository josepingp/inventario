<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Nuevo Usuario</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest" mb-6 mt-6></div>

    <form action="./php/user_save.php" method="POST" class="ajax_form" autocomplete="off">
        <div class="colums">
            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input type="text" class="input" name="user_name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                        maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label for="">Apellidos</label>
                    <input type="text" class="input" name="user_last_name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                        maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label for="">Usuario</label>
                    <input type="text" class="input" name="user_user" pattern="[a-zA-Z0-9ñÑ]{4,29}" maxlength="20"
                        required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label for="">Email</label>
                    <input type="email" class="input" name="user_email" maxlength="70">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Clave</label>
                    <input type="password" class="input" name="user_key_1"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label for="">Repetir clave</label>
                    <input type="password" class="input" name="user_key_2"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

