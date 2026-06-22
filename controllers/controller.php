<?php
class MvcController
{
    public function plantilla()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // ⚠ Detectar si la acción es exportar clientes
        if (isset($_GET["action"]) && $_GET["action"] === "exportarClientes") {
            require "views/modules/exportarClientes.php";
            exit; 
        }
        
        // ⚠ Nueva: Detectar si la acción es guardar configuración de formulario
        if (isset($_GET["action"]) && $_GET["action"] === "guardarConfigForm") {
            require "views/modules/functions/guardarConfigForm.php";
            exit; 
        }

        include "views/template.php";
    }

    public function enlacesPaginasController()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $enlaces = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?: 'index';
        $param1 = filter_input(INPUT_GET, 'param1', FILTER_SANITIZE_NUMBER_INT);
        $param2 = filter_input(INPUT_GET, 'param2', FILTER_SANITIZE_NUMBER_INT);

        $_GET['params'] = [$param1, $param2];

        $respuesta = Paginas::enlacesPaginasModel($enlaces);
        include $respuesta;
    }
}