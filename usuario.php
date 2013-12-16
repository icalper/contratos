<?php
require './librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_SUPERADMIN;
$sesion = new manejadorSesion;


$formulario = filter_input(INPUT_GET, "f");
$accion = filter_input(INPUT_POST, "accion");
include './librerias/usuario_funciones.php';
if ($sesion->getPrivilegios() < $nivelAcceso) {
    header("Location: index.php");
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
                    <?php 
                    switch($formulario){        // Agregar usuario
                         case "a": ?>
                           
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
                    
                    <?php  break;               // Modificar usuarios
                       case "m": ?>
                    
                    <h1>Modificar usuario</h1>
                    <?php $usuario = getUsuario(filter_input(INPUT_GET, "u"))?>
                    <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1]; unset($_SESSION['msg'])?></h2>
                    <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']?>">
                            <p><span>Usuario:</span>
                                <input class="contact" disabled type="text" name="usuario" value="<?php echo $usuario['nomUsuario']?>"/></p>

                            <p><span>Nombre:</span>
                                <input class="contact" type="text" name="nombre" value="<?php echo $usuario['nomPersonaUsuario']?>"/></p>

                            <p><span>Contraseña:</span>
                                <input class="contact" type="password" name="password"/></p>

                            <p><span>Departamento:</span>
                                <input class="contact" type="text" name="depto" value="<?php echo $usuario['depUsuario']?>"/></p>

                            <p><span>Nivel de acceso:</span>
                                <select size="3" name="privilegios">
                                    <option <?php  if($usuario['tipoUsuario'] == 1) {echo 'selected';}?> value="1">Creador de contratos</option>
                                    <option <?php  if($usuario['tipoUsuario'] == 2) {echo 'selected';}?> value="2">Supervisor de contratos(s)</option>
                                    <option <?php  if($usuario['tipoUsuario'] == 3) {echo 'selected';}?> value="3">Administrador</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Modificar"/>
                        </div>
                    </form>

                    <?php  break;               // Eliminacion de usuarios
                       case "e": ?>
                    
                    <h1>Eliminar usuario</h1>
                     <?php $usuario = getUsuario(filter_input(INPUT_GET, "u"))?>
                    <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1]; unset($_SESSION['msg'])?></h2>
                    <h2 style="color: red">¡ATENCION! Confirme que desea eliminar el siguiente usuario:</h2>
                    <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']?>">
                            <p><span>Usuario:</span>
                                <input class="contact" disabled type="text" name="usuario" value="<?php echo $usuario['nomUsuario']?>"/></p>

                            <p><span>Nombre:</span>
                                <input class="contact" disabled type="text" name="nombre" value="<?php echo $usuario['nomPersonaUsuario']?>"/></p>

                            <p><span>Departamento:</span>
                                <input class="contact" disabled type="text" name="depto" value="<?php echo $usuario['depUsuario']?>"/></p>

                            <p><span>Nivel de acceso:</span>
                                <select disabled name="privilegios">
                                    
                                    <option <?php  if($usuario['tipoUsuario'] == 1) {echo 'selected';}?> value="1">Creador de contratos</option>
                                    <option <?php  if($usuario['tipoUsuario'] == 2) {echo 'selected';}?> value="2">Supervisor de contratos(s)</option>
                                    <option <?php  if($usuario['tipoUsuario'] == 3) {echo 'selected';}?> value="3">Administrador</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Eliminar"/>
                        </div>
                    </form>
                    
                    <?php  break;              // Asignaciones
                       case "as": ?>               
                        <?php 
                        $contratos_nombres = array(
                            co => "Contrato de Obra",
                            cs => "Contrato de Servicio",
                            cci => "Contrato con Instalación",
                            aa => "Acuerdo Administrativo"
                        );
                        $contrato_eliminar = filter_input(INPUT_GET, "c");
                        if($contrato_eliminar != ""){
                            eliminarContrato($contrato_eliminar);
                        }
                        $usuario = getUsuario(filter_input(INPUT_GET, "u"));
                        $contratos = getContratos(filter_input(INPUT_GET, "u"));
                        ?>
                        <h1>Asignaciones para <?php echo $usuario['nomUsuario']?></h1>
                        <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1]; unset($_SESSION['msg'])?></h2>
                        <form action="usuario.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="asignar">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']?>">
                            <p><span>Contrato:</span>
                            <input class="contact" type="text" name="numContrato"/></p>
                        <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Asignar"/>
                        </div>
                        </form>
                        
                        <table>
                        <thead><th>Contrato</th><th>Tipo</th><th>Accion</th></thead>
                        <tbody>
                            <?php
                            foreach ($contratos as $contrato) {
                            echo "<tr><td>".$contrato['numContrato']."</td><td>".
                            $contratos_nombres[strtolower($contrato['tipo'])]."</td><td>"
                                    . "<a href=\"usuario.php?f=as&u=".$usuario['idUsuario'].
                                    "&c=".$contrato['idAsignacion']."\">Eliminar asignacion</a>"
                                    . "</td></tr>";
                        }
                        ?>
                        </tbody>
                        </table>
                        
                    <?php  break;               // Lista de usuarios
                        default : ?>
                    
                    <h1>Lista de usuarios</h1>
                    <?php $usuarios = getUsuarios();?>
                    <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1]; unset($_SESSION['msg'])?></h2>
                    <table>
                        <thead><th>Usuario</th><th>Nombre</th><th>Nivel</th><th>Acciones</th></thead>
                    <tbody>
                        <?php 
                        $privilegios_nombres = array("", "Creador de contratos", "Supervisor de contratos", "Administrador");
                        foreach ($usuarios as $usuario) {
                            echo "<tr><td>".$usuario['nomUsuario']."</td><td>".
                                    $usuario['nomPersonaUsuario']."</td><td>".
                                    $privilegios_nombres[$usuario['tipoUsuario']]."</td><td>";
                            if($usuario['tipoUsuario'] == 2){
                                echo "<a href=\"usuario.php?f=as&u=".
                                    $usuario['idUsuario']."\">Asignaciones</a> - ";
                            }
                            echo "<a href=\"usuario.php?f=m&u=".
                                    $usuario['idUsuario']."\">Modificar</a>"
                                    . " - <a href=\"usuario.php?f=e&u="
                                    .$usuario['idUsuario']."\">Eliminar</a>"
                                    . "</td></tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                    
                    
                    <?php } ?>
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
<?php } mysql_close($db);?>
            });
        </script>
    </body>
</html>
