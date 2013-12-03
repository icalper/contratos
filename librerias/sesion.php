<?php
session_start();

class manejadorSesion {

    var $nombreUsuario;
    var $privilegios;
    var $listaContratos;
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
            $this->listaContratos = $datos[2];
        } else {
            $this->privilegios = manejadorSesion::USUARIO_DESCONOCIDO;
        }
    }

    function registrar($nombreUsuario, $privilegios, $listaContratos) {
        $_SESSION['sesion'] = array($nombreUsuario, $privilegios, $listaContratos);
        $this->nombreUsuario = $nombreUsuario;
        $this->privilegios = $privilegios;
        $this->listaContratos = $listaContratos;
    }
    
    function terminar() {
        $_SESSION['sesion'] = NULL;
        $this->nombreUsuario = NULL;
        $this->privilegios = NULL;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }
    
    function getListaContratos() {
        return $this->listaContratos;
    }

    function getPrivilegios() {
        return $this->privilegios;
    }

}
