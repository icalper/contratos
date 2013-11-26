<html>
    <head>

        <?php
        $campos = array('especialidad', 'numContrato', 'descripcion', 'tipoContrato', 'residente', 'supPlantas', 'supElectrico', 'supMecanica', 'supCivil', 'supInstrumento', 'faseUssipa', 'inicio', 'termino');
        $nombres_campos = array('Especialidad', 'Numero de Contrato', 'Descripcion', 'Tipo de Contrato', 'Residente', 'Supervisor Fase Plantas', 'Supervisor Fase Electrico', 'Supervisor Fase Mecanica', 'Supervisor Fase Civil', 'Supervisor Fase Instrumentos', 'Fase USSIPA', 'Fecha de Inicio', 'Fecha de Termino');

        $campos_consulta = array();

        for ($i = 0; $i < 50; $i++)
            array_push($campos_consulta, $_POST[$i]);

        $campos_filtrados = array_filter($campos_consulta);
        ?>

        <meta charset="UTF-8">
        <title>Consulta de contratos de Servicio</title>
        <style type="text/css" title="currentStyle">
            @import "../../datatables/media/css/demo_table.css";
        </style>
        <script type="text/javascript" charset="utf-8" src="../../datatables/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#contratos').dataTable({
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": false,
                    "sAjaxSource": "server_processing.php",
                    "sScrollY": "80%", 
                    "sScrollX": "100%",
                    "bScrollCollapse": true,
                    "oLanguage": {
                        "sUrl": "../../datatables/media/language/spanish.txt"
                    },
                    "aoColumns": [
                    <?php
                    $primero = true;
                    foreach ($campos as $id => $valor) {
                        if (!in_array($valor, $campos_filtrados)) {
                            if ($primero) {
                                echo "{ \"bSearchable\": false, \"bVisible\": false }";
                                $primero = false;
                            } else {
                                echo ", { \"bSearchable\": false, \"bVisible\": false }";
                            }
                        } else {
                            if ($primero) {
                                echo "null";
                                $primero = false;
                            } else {
                                echo ", null";
                            }
                        }
                    }
                    ?>
                    ]
                });
            });
        </script>
        
    </head>
    <body>

        <form action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" method="POST">
            <table style="border-width: 0" class="display">
                <?php
                echo ("<tr>");
                foreach ($nombres_campos as $id => $valor) {
                    if ($id % 3 == 0)
                        echo ("</tr><tr>");
                    echo ("<td><input type=\"checkbox\" name=\"$id\" value=\"$campos[$id]\">$nombres_campos[$id]</td>");
                }
                echo ("</tr>");
                ?>
            </table>
            <input type="submit" name="Enviar" value="Consultar">
        </form>


        <table id="contratos" class="display">
            <thead>
                <tr>
                    <?php
                    foreach ($campos as $id => $valor) {
                        if ($valor == "descripcion")
                            echo "<th width=\"600px\">$nombres_campos[$id]</th>";
                        else
                            echo "<th>$nombres_campos[$id]</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>

        <?php
// put your code here
        ?>
    </body>
</html>
