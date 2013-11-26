<?php
require './librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_DESCONOCIDO;
$sesion = new manejadorSesion;

if ($sesion->getPrivilegios() > $nivelAcceso) {
    header("Location: index.php");
}
?>
<html>

    <head>
        <title>Inicio de sesión</title>
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
                        <h1><a href="index.html">Gestion <span class="logo_colour">de contratos</span></a></h1>
                        <h2>PEMEX</a></h2>
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
                    <h1>Inicio de sesión</h1>
                    <form id="login" action="librerias/procesar_login.php" method="POST">
                        <div class="form_settings">
                            <p><span>Usuario:</span>
                                <input id="usuario" type="text" name="usuario"/></p>

                            <p><span>Contraseña:</span>
                                <input id="password" type="password" name="password"/></p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Acceder"/>
                        </div>
                    </form>
                </div>
            </div>
            <footer>
                <p>Copyright &copy; photo_style_two | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
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
            });
        </script>
    </body>
</html>
