<?php

class pagoController
{
    public static function crearPago($id_venta, $monto)
    {
        return pagoModel::crearPago([
            "id_venta" => $id_venta,
            "valor" => $monto,
            "metodo_pago" => "bold"
        ]);
    }
}
