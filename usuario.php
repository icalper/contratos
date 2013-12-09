<?php
require './librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_SUPERADMIN;
$sesion = new manejadorSesion;


$tipo = filter_input(INPUT_GET, "a");
$accion = filter_input(INPUT_POST, "accion");
include './librerias/usuario_funciones.php';
if ($sesion->getPrivilegios() < $nivelAcceso) {
    //header("Location: index.php");
}
?>
<html>

    <head>
        <title>Administracion de usuarios</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <!-- modernizr enables HTML5 elements and feature detects -->
        <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
    </head>

    <body>
        <div id="main">
            <header>
                <div id="logo">
                    <div id="logo_text">
                        <!-- class="logo_colour", allows you to change the colour of the text -->
                        <h1><a href="index.php">Gestion <span class="logo_colour">de contratos</span></a></h1>
                        <h2>PEMEX</h2>
                    </div>
                </div>
                <nav>
                    <?php
                    $menuNivel = "";
                    require 'menu.php';
                    ?>
                </nav>
            </header>
            <div id="site_content">
                <div id="content">


                    <h1>Agregar usuario</h1>
                    <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1]; unset($_SESSION['msg'])?></h2>
                    <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="agregar">
                            <p><span>Usuario:</span>
                                <input class="contact" type="text" name="usuario"/></p>

                            <p><span>Nombre:</span>
                                <input class="contact" type="text" name="nombre"/></p>

                            <p><span>Contraseña:</span>
                                <input class="contact" type="password" name="password"/></p>

                            <p><span>Departamento:</span>
                                <input class="contact" type="text" name="depto"/></p>

                            <p><span>Nivel de acceso:</span>
                                <select size="3" name="privilegios">
                                    <option value="1">Creador de contratos</option>
                                    <option value="2">Supervisor de contratos(s)</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Agregar"/>
                        </div>
                    </form>

                    <h1>Modificar usuario</h1>
                    <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="modificar">
                            <p><span>Usuario:</span>
                                <input class="contact" disabled type="text" name="usuario"/></p>

                            <p><span>Nombre:</span>
                                <input class="contact" type="text" name="nombre"/></p>

                            <p><span>Contraseña:</span>
                                <input class="contact" type="password" name="password"/></p>

                            <p><span>Departamento:</span>
                                <input class="contact" type="text" name="depto"/></p>

                            <p><span>Nivel de acceso:</span>
                                <select size="3" name="privilegios">
                                    <option value="1">Creador de contratos</option>
                                    <option value="2">Supervisor de contratos(s)</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Modificar"/>
                        </div>
                    </form>

                    <h1>Eliminar usuario</h1>
                    <h2 style="color: red">¡ATENCION! Confirme que desea eliminar el siguiente usuario:</h2>
                    <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="eliminar_definitivo">
                            <p><span>Usuario:</span>
                                <input class="contact" disabled type="text" name="usuario"/></p>

                            <p><span>Nombre:</span>
                                <input class="contact" disabled type="text" name="nombre"/></p>

                            <p><span>Departamento:</span>
                                <input class="contact" disabled type="text" name="depto"/></p>

                            <p><span>Nivel de acceso:</span>
                                <select disabled name="privilegios">
                                    <option  value="1">Creador de contratos</option>
                                    <option value="2">Supervisor de contratos(s)</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Eliminar"/>
                        </div>
                    </form>


                </div>
            </div>
            <footer>
<!--                <p>Copyright &copy; photo_style_two | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>-->
            </footer>
        </div>
        <p>&nbsp;</p>
        <!-- javascript at the bottom for fast page loading -->
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
        <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('ul.sf-menu').sooperfish();
<?php if (sizeof($msg) > 1) { ?>
                    alert("<?php echo $msg ?>");
<?php } ?>
            });
        </script>
    </body>
</html>
