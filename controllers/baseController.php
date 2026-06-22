<?php
class baseController
{
	protected static function sumarDiasHabiles(int $dias): string
{
    // Arranca desde medianoche de hoy, no desde la hora actual
    $fecha = new DateTime('today', new DateTimeZone('America/Bogota'));
    $contados = 0;

    while ($contados < $dias) {
        $fecha->modify('+1 day');
        if ($fecha->format('N') < 6) {
            $contados++;
        }
    }

    return $fecha->format('Y-m-d H:i:s');
}
	// Función auxiliar para mostrar alertas con SweetAlert
	public function mostrarAlerta($icon, $message, $redirect)
	{
		$url = BASE_URL . $redirect;
		echo "<script>
            Swal.fire({icon: '$icon', title: 'Aviso', text: '$message'})
            .then(() => { window.location.href = '$url'; });
        </script>";
	}

	// Función para enviar correos
	public function enviarCorreo($email, $subject, $mensaje)
	{
		$url = getenv('MAIL_URL');
		$apiKey = getenv('API_KEY');
		$from = getenv('MAIL_FROM');

		$data = json_encode([
			"from" => $from,
			"to" => $email,
			"subject" => $subject,
			"html" => $mensaje
		]);

		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json',
				'Authorization: Bearer ' . $apiKey,
				'Content-Length: ' . strlen($data)
			]
		]);

		$result = curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
			error_log("Error sending email: " . $result);
		}
		curl_close($ch);
	}

	public function bitacora($mensaje, $url = "", $id_servicio = null, $id_asesor = null)
	{
		date_default_timezone_set("America/Bogota");
		$fecha = date("Y-m-d H:i:s");

		$datosModel = [
			"mensaje" => $mensaje,
			"fecha" => $fecha,
			"url" => $url,
			"id_servicio" => $id_servicio,
			"id_asesor" => $id_asesor
		];

		return model::registrarBitacora($datosModel, "bitacora");
	}


}
