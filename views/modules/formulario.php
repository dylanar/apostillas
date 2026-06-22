<?php
if (!isset($_GET["param1"]) || empty($_GET["param1"])) {
    // Mostrar alerta y redirigir inmediatamente
    echo '
    <script>
    Swal.fire({
        title: "Código requerido",
        text: "Debes ingresar un código válido para acceder a esta página.",
        icon: "warning",
        confirmButtonText: "Ir al registro",
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(() => {
        window.location.href = "' . BASE_URL . 'registro";
    });
    </script>
    ';
    exit();
} else {
    $codigo = $_GET["param1"];

    $respuesta = model::consultaDatoModel("enlace_temporal", "codigo", $codigo);

    if ($respuesta && is_array($respuesta)) {
        if ($respuesta["estado"] != 1) {
            echo '
     
        <script>
        Swal.fire({
            title: "Código vencido",
            text: "El código ingresado ha expirado. Comuníquese con su asesor.",
            icon: "info",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#090830"
        }).then(() => {
            window.location.href = "' . BASE_URL . 'registro";
        });
        </script>
        ';
            return;
        } else {

            if ($respuesta["tipo"] === "venta_web") {
                $id_venta = $respuesta["data"];
                $consultaVenta = model::consultaDatoModel("ventas", "id", $id_venta);

                $id_servicio = $consultaVenta["id_servicio"];
                $id_asesor = $consultaVenta["id_asesor"];
            } else {
                $data = json_decode($respuesta["data"], true);

                $id_servicio = $data["id_servicio"];
                $id_asesor = $data["id_asesor"];
                $cantidad_doc = $data["cantidad_doc"];
                $abono_inicial = $data["abono_inicial"];
                $precio = $data["precio"];
                $fecha_entrega = $data["fecha_entrega"];
                $metodo_pago = $data["metodo_pago"] ?? '';
                $fecha_pago = $data["fecha_pago"] ?? '';
            }


            $servicio = model::consultaDatoModel("servicios", "id", $id_servicio);

            $formularioJSON = $servicio["formulario"] ?? '{"campos":[]}';
            $camposFormulario = json_decode($formularioJSON, true)['campos'];

            if ($respuesta["tipo"] != "venta_web") {
                $asesor = model::consultaDatoModel("usuarios", "id", $id_asesor);
                $nombre_asesor = $asesor["nombre"] ?? "";

                $data = json_decode($respuesta["data"], true);
                $codigo_referido = $data["codigo_referido"] ?? "";
                
                if (isset($data["id_cliente"])) {

                    $cliente = model::consultaDatoModel("clientes", "id", $data["id_cliente"]);
                    $id_cliente = $cliente["id"];
          
                    include_once "components/render-form-user.php";
                } else {
                    include_once "components/render-form.php";
                }


            } else {

                $cliente = model::consultaDatoModel("clientes", "id", $consultaVenta["id_cliente"]);
                $id_cliente = $cliente["id"];
                $codigo_seguimiento = $consultaVenta["codigo"];
                include_once "components/render-form-venta-web.php";
            }



        }
    } else {
        echo '
    
    <script>
    Swal.fire({
        title: "Código inválido",
        text: "El código no existe en nuestro sistema. Comuníquese con un asesor.",
        icon: "error",
        confirmButtonText: "Reintentar",
        confirmButtonColor: "#090830"
    }).then(() => {
        window.location.href = "' . BASE_URL . 'registro";
    });
    </script>
    ';
        return;
    }
}
?>