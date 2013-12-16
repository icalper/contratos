<ul class="sf-menu" id="nav">
    <li class="selected"><a href="<?php echo $menuNivel; ?>index.php">Inicio</a></li>
    <?php if($sesion->getPrivilegios() >= manejadorSesion::USUARIO_SUPERVISOR) { ?>
    <li><a href="#">Consulta</a>
        <ul><?php $tipoContratos = $sesion->getTipoContratos() ?>
            <?php if ($tipoContratos == 0 || in_array("cs", $tipoContratos)) {?>
            <li><a href="<?php echo $menuNivel; ?>consulta/cs/">Contrato de Servicio</a></li><?php } ?>
            <?php if ($tipoContratos == 0 || in_array("co", $tipoContratos)) {?>
            <li><a href="<?php echo $menuNivel; ?>consulta/co/">Contrato de Obra</a></li><?php } ?>
            <?php if ($tipoContratos == 0 || in_array("cci", $tipoContratos)) {?>
            <li><a href="<?php echo $menuNivel; ?>consulta/cci/">Contrato de Compra con Instalacion</a></li><?php } ?>
            <?php if ($tipoContratos == 0 || in_array("aa", $tipoContratos)) {?>
            <li><a href="<?php echo $menuNivel; ?>consulta/aa/">Acuerdos Administrativos</a></li><?php } ?>
        </ul>
    </li>
    
   <?php }?>
    <?php if($sesion->getPrivilegios() >= manejadorSesion::USUARIO_ADMIN) { ?>
    <li><a href="#">Importar</a>
        <ul>
            <li><a href="<?php echo $menuNivel; ?>importar/importar_cs.php">Contrato de Servicio</a></li>
            <li><a href="<?php echo $menuNivel; ?>importar/importar_co.php">Contrato de Obra</a></li>
            <li><a href="<?php echo $menuNivel; ?>importar/importar_compras_inst.php">Contrato de Compra con Instalacion</a></li>
            <li><a href="<?php echo $menuNivel; ?>importar/importar_acuerdos.php">Contrato de Acuerdos Administrativos</a></li>
        </ul>
    </li>
    <?php }?>
    <?php if($sesion->getPrivilegios() == manejadorSesion::USUARIO_SUPERADMIN) { ?>
    <li><a href="#">Usuarios</a>
    <ul>
        <li><a href="<?php echo $menuNivel; ?>usuario.php?f=a">Agregar usuario</a></li>
        <li><a href="<?php echo $menuNivel; ?>usuario.php">Lista de usuarios</a></li>
    </ul></li>
    <?php }?>
</ul>
<ul class="sf-menu" id="nav2">
    <li>
        <?php
        if ($sesion->getPrivilegios() == manejadorSesion::USUARIO_DESCONOCIDO) {
            $texto = "Iniciar sesión...";
            $link = $menuNivel . "login.php";
            ?>
            <a href="<?php echo $link; ?>"><?php echo $texto; ?></a>
            <?php
        } else {

            $texto = "Usuario: " . $sesion->getNombreUsuario()[0];
            $link = "#";
            $link_logout = $menuNivel . "logout.php";
            ?>
            <a href="<?php echo $link; ?>"><?php echo $texto; ?></a>
            <?php
            echo "<ul>";
//            echo "<li><a href=\"#\">".$sesion->getNombreUsuario()[1]."</a></li>";
            echo "<li><a href=\"$link_logout\">Cerrar sesión</a>";
            echo "</li></ul>";
        }
        ?>
    </li>
</ul>