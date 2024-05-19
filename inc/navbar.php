<nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a href="index.php?view=home" class="navbar-item">    
                <img src="./assets/img/logo-sin-fondo.png" alt="logo" width="40" >
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Usuarios
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="index.php?view=new_user">
                            Nuevo
                        </a>
                        <a class="navbar-item" href="index.php?view=user_list">
                            Lista
                        </a>
                        <a class="navbar-item" href="index.php?view=user_search">
                            Buscar
                        </a>
                        
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Categorías
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="index.php?view=category_new">
                            Nueva
                        </a>
                        <a class="navbar-item" href="index.php?view=category_list">
                            Lista
                        </a>
                        <a class="navbar-item" href="index.php?view=category_search">
                            Buscar
                        </a>
                        
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" >
                        Productos
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item"> Nuevo </a>
                        <a class="navbar-item">
                            Lista
                        </a>
                        <a class="navbar-item">
                            Buscar
                        </a>
                        
                    </div>
                </div>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary is-rounded" href="index.php?view=user_update&user_id_up=<?php echo $_SESSION['id'] ?>">
                            Mi cuenta
                        </a>
                        <a class="button is-light is-link is-rounded" href="index.php?view=logout">
                        Salir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>