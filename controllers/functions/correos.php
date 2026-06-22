<?php 

function enviarCorreo($email, $subject, $mensaje)
{
    $url = 'https://api.resend.com/emails';
    $apiKey = 're_YMehAao4_Qh8sT6woQibHAJnqbgrQ4bAF';

    $data = array(
        'from' => 'contactos@apostillasylegalizaciones.com',
        'to' => $email,
        'subject' => $subject,
        'html' => $mensaje
    );

    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
        'Content-Length: ' . strlen($data_string)
    ));

    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_status != 200) {
        error_log("Error sending email: " . $result);
    }
}