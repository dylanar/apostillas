<?php

function enviarWhatsAppZenviaTemplate($to, $templateId, array $fields = [], $externalId = null)
{
    // 🔥 QUEMADOS (fijos)
    $apiToken = "vNye-wxjNDmGswb6NpBhjEcrUrg-v91Z3Mdr";
    $from     = "573207387975";

    $url = "https://api.zenvia.com/v2/channels/whatsapp/messages";

    $payload = [
        "from" => $from,
        "to" => $to,
        "contents" => [
            [
                "type" => "template",
                "templateId" => $templateId,
                "fields" => $fields
            ]
        ]
    ];

    // externalId opcional (sirve para tracking)
    if (!empty($externalId)) {
        $payload["externalId"] = $externalId;
    }

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-API-TOKEN: " . $apiToken
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);

        return [
            "success" => false,
            "httpCode" => $httpCode,
            "error" => $error
        ];
    }

    curl_close($ch);

    return [
        "success" => ($httpCode >= 200 && $httpCode < 300),
        "httpCode" => $httpCode,
        "response" => json_decode($response, true),
        "raw" => $response
    ];
}
