<html>
    <head>

        <?php
        $campos = array('especialidad', 'descripcion', 'tipoContrato','compañia', 'supervisor', 'inicio', 'plazoEjecucion', 'estado');
        
        $nombres_campos = array('Especialidad', 'Descripcion', 'Tipo De Contrato', 'Compania', 'Supervisor', 'Fecha De Inicio', 
            'Plazo De Ejecucion', 'Estado Que Guarda');

      $ancho_campos = array ('100px', '160px', '250px', '200px', '200px', '200px', '200px', '200px', '200px', '200px');

        $campos_consulta = array();

        for ($i = 0; $i < 50; $i++)
            array_push($campos_consulta, $_POST[$i]);

        $campos_filtrados = array_filter($campos_consulta);
        ?>

        <meta charset="UTF-8">
        <title>Consulta de contratos de Servicio</title>
        <style type="text/css" title="currentStyle">
            @import "../datatables/media/css/jquery.dataTables_themeroller.css";
            @import "../themeroller/css/cupertino/jquery-ui-1.10.3.custom.css";
        </style>
        <script type="text/javascript" charset="utf-8" src="../datatables/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery.jeditable.js"></script>
        <script type="text/javascript" charset="utf-8" src="../datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#excel').click(function() {
                    var sTabla = oTable.$('input').serialize();
                    var sCampos = $('#campos').serialize();
//                    alert(sCampos);
                    var sDatos = sTabla+"&"+sCampos;
                    //alert(sDatos);
                    window.open('imprimirCCI.php?'+sDatos);
//                    $.post("imprimirCO.php", sDatos);
                    return false;
                });

                oTable = $('#contratos').dataTable({
                    "bJQueryUI": true,
                    "bLengthChange": false,
                    "bProcessing": true,
                    "bServerSide": true,
                    "bStateSave": true,
                    "bPaginate": false,
                    //"sPaginationType": "full_numbers",
                    "sAjaxSource": "server_processing.php",
                    "sScrollY": "60%",
                    "sScrollX": "200%",
                    //"bScrollCollapse": true,
                    "oLanguage": {
                        "sUrl": "../datatables/media/language/spanish.txt"
                    },
                    "fnDrawCallback": function () {
                        $('#contratos tbody td[class!="readonly"]').editable( 'ajax.php', {
                            "callback": function( sValue, y ) {
                            /* Redraw the table from the new data on the server */
                            oTable.fnDraw();
                            },
                            "submitdata": function ( value, settings ) {
                            return {
                            "row_id": this.parentNode.getAttribute('id'),
                            "column": oTable.fnGetPosition( this )[2]
                            }},
                        "height": "25px"
                    } ); },
                    "aoColumns": [
                        { "bSearchable": false, "bVisible": false },
                        {"sClass": "readonly", "mRender": function(data, type, full) {
                                return '<input type="checkbox" name="' + full.DT_RowId + '" value="' + data + '"> ' + data;
                            }},
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


//                Este codigo es util para añadir un evento al hacer click en un elemento
//                de la tabla. MANTENER por si se necesita
//                $('#contratos tbody tr').live('click', function () {
//                var nTds = $('td', this);
//                var sPreId = $(nTds[0]).text();
//                var sId =sPreId.substring(1);
//                
//                alert( sId )
//            } );

            });
        </script>

    </head>
    <body>

        <form id="campos" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" method="POST">
            <table style="border-width: 0" class="display">
                <?php
                echo ("<tr>");
                foreach ($campos as $id => $valor) {
                    if ($id % 5 == 0){
                        echo ("</tr><tr>");
                    }
                    $checked= "";
                    if (in_array($valor, $campos_filtrados)) {$checked="checked";}
                    echo ("<td><input type=\"checkbox\" name=\"$id\" value=\"$valor\" $checked>$nombres_campos[$id]</td>");
                }
                echo ("</tr>");
                ?>
            </table>
            <input type="submit" name="Enviar" value="Consultar">
        </form>

        <form id="formulario" method="POST">
            <button id="excel">Imprimir a Excel</button>
            <table id="contratos" class="display">
                <thead>
                    <tr>
                        <th>id</th>
                        <th width="160px">Contrato</th>
                        <?php
                        foreach ($campos as $id => $valor) {
                            if ($valor == "descripcion")
                                echo "<th width=\"600px\">$nombres_campos[$id]</th>";
                            else
                                //echo "<th>".$nombres_campos[$id]."</th>"; 
                                echo "<th width=\"ancho_campos[$id]\">$nombres_campos[$id]</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </form>
    </body>
</html>
