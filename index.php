<?php
session_start();
setlocale(LC_ALL, 'es_ES.UTF-8');
header('Content-type: text/html; charset=utf-8');

// Cargar el archivo .env usando Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Definir BASE_URL desde .env
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/apostillas/');
define('ASSETS_URL', getenv('ASSETS_URL') ?: BASE_URL . "views/assets/");

// CONTROLADORES
require_once "controllers/controller.php";
require_once "controllers/baseController.php";
require_once "controllers/clienteController.php";
require_once "controllers/ventaController.php";
require_once "controllers/pagoController.php";
require_once "controllers/referidosController.php";
require_once "controllers/creditoController.php";


// MODELOS
require_once "models/enlaces.php";
require_once "models/conexion.php";
require_once "models/model.php";
require_once "models/ventaModel.php";

require_once "models/clienteModel.php";
require_once "models/pagoModel.php";
require_once "models/referidosModel.php";
require_once "models/creditoModel.php";


$plantilla = new MvcController();
$plantilla->plantilla();
