<?php
session_start();

class manejadorSesion {

    var $nombreUsuario;
    var $privilegios;
    const USUARIO_DESCONOCIDO=-1;
    const USUARIO_CREADOR = 1;
    const USUARIO_SUPERVISOR=2;
    const USUARIO_ADMIN=3;
    const USUARIO_SUPERADMIN=4;
    
    function __construct() {
        $datos = $_SESSION['sesion'];
        if (is_array($datos)) {
            $this->nombreUsuario = $datos[0];
            $this->privilegios = $datos[1];
        } else {
            $this->privilegios = manejadorSesion::USUARIO_DESCONOCIDO;
        }
    }

    function registrar($nombreUsuario, $privilegios) {
        $_SESSION['sesion'] = array($nombreUsuario, $privilegios);
        $this->nombreUsuario = $nombreUsuario;
        $this->privilegios = $privilegios;
    }
    
    function terminar() {
        $_SESSION['sesion'] = NULL;
        $this->nombreUsuario = NULL;
        $this->privilegios = NULL;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    function getPrivilegios() {
        return $this->privilegios;
    }

}
