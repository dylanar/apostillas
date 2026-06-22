<?php

class Paginas
{
    public static function enlacesPaginasModel($enlaces)
    {
        // Rutas públicas permitidas
        $rutasPublicas = [
            "404",
            "home",
            "formulario",
            "registro",
            "registro-exitoso",
            "elegir-servicio",
            "elegir-pais",
            "revision-documentos",
            "pagar-servicio",
            "documentos",
            "apostilla-colombia",
            "apostilla-usa",
            "apostilla-espana",
            "radicacion-convalidacion",
            "convalidar-titulo",
            "casos-exito",
            "traducciones-oficiales",
            "recoleccion-documentos",
            "estudiar",
            "tutelas",
            "derecho-peticion",
            "asesoria-legal-personalizada",
            "respuesta-men",
            "nosotros",
            "casos-exito",
            "preguntas-frecuentes",
            "contacto",
            "resultado-pago",
            "referidos",
            "credito"
        ];

        // Si es ruta pública, permitir acceso
        if (in_array($enlaces, $rutasPublicas)) {
            return "views/modules/" . $enlaces . ".php";
        }

        // Si ingresan la ruta principal
        if ($enlaces === "index") {
            return "views/modules/home.php";
        }

        // Si no es una ruta válida
        return "views/modules/404.php";
    }
}
