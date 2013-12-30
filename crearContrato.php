<?php
require './librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_CREADOR;
$sesion = new manejadorSesion;


$c = filter_input(INPUT_GET, "c");
$accion = filter_input(INPUT_POST, "accion");

include './librerias/crearContrato_funciones.php';

if ($sesion->getPrivilegios() != $nivelAcceso) {
    header("Location: index.php");
}
?>
<html>

    <head>
        <title>Creación de Contratos</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" href="librerias/jquery-ui-1.10.3.custom/css/smoothness/jquery-ui-1.10.3.custom.min.css">
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

                    <h1>Crear Contrato</h1>
                    <h2 style="color: <?php echo $_SESSION['msg'][0]; ?>">
                        <?php echo $_SESSION['msg'][1];
                        unset($_SESSION['msg'])
                        ?></h2>
                    <form action="crearContrato.php" method="POST">
                        <div class="form_settings">
                            <input type="hidden" name="accion" value="crear">
                            <input type="hidden" name="tipoc" value="<?php echo $c; ?>">
                            <p><span>Nº Contrato:</span>
                                <input class="contact" type="text" name="contrato"/></p>

                            <p><span>Especialidad:</span>
                                <input class="contact" type="text" name="especialidad"/></p>
                            
                            <?php if($c != "aa"){?>
                            <p><span>Compañia:</span>
                                <input class="contact" type="text" name="compania"/></p>
                            <?php }?>
                            <p><span>Descripcion:</span>
                                <textarea rows="6" name="descripcion"></textarea></p>
                            
                            <?php if($c == "cs" || $c == "co"){?>
                            <p><span>Monto:</span>
                                <input class="contact" type="text" name="cmmonto"/></p>
                            <?php }?>
                            
                            <p><span>Fecha Inicio:</span>
                                <input class="contact" id="fecha" type="text" name="fechainicio"/></p><?php
                                
                                if($c == "cs" || $c == "co" || $c == "aa"){ 
                              ?><p><span>Fecha de Termino:</span>
                                <input class="contact" id="fecha2" type="text" name="termino"/></p><?php }
                            
                            if($c == "cs" || $c == "co" || $c == "cci"){
                              
                              ?><p><span>Plazo de Ejecucion:</span>
                                <input class="contact" type="text" name="plazoejecucion"/></p><?php }
                            
                            if($c == "cs" || $c == "co"){
                                
                              ?><p><span>Num. Pedido SAP:</span>
                                <input class="contact" type="text" name="sap"/></p><?php }
                            
                            if($c == "cs" || $c == "co"){
                                
                              ?><p><span>Unidad de Inversion:</span>
                                <input class="contact" type="text" name="unidadinversion"/></p><?php }?>
                            <p><span>Tipo de contrato:</span>
                                <select disabled size="4" name="tipoc2">
                                    <option <?php if($c == "aa") { echo "selected"; }?> value="aa">Acuerdo Administrativo</option>
                                    <option <?php if($c == "cci") { echo "selected"; }?> value="cci">Compra con Instalación</option>
                                    <option <?php if($c == "co") { echo "selected"; }?> value="co">Contrato de Obra</option>
                                    <option <?php if($c == "cs") { echo "selected"; }?> value="cs">Contrato de Servicio</option>
                                </select>
                            </p>
                            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="Crear"/>
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
        <script type="text/javascript" src="librerias/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="librerias/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
        <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
        <script type="text/javascript" src="librerias/jquery.ui.datepicker-es.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('ul.sf-menu').sooperfish();
            });
        </script>
        <script type="text/javascript">
            $.datepicker.setDefaults(
                    $.extend(
                            {'dateFormat': 'yyyy-mm-dd'},
                    $.datepicker.regional['es']
                            )
                    );
            //insercion de fecha
            $(function() {
                $("#fecha").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });
                $("#fecha2").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });
            });
            //$.datepicker.setDefaults($.datepicker.regional['es-MX']);
        </script>
    </body>
</html>
<?php mysql_close($db); ?>

