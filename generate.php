<?php
error_reporting(0);
$url = $_POST["link"];
$apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&color=FFFFFF&bgcolor=1c1c1c&data=" . urlencode($url);
$qr_code_img = file_get_contents($apiUrl);

// Bitly Shortener
$api_url = 'https://api-ssl.bitly.com/v4/shorten';
$access_token = '6947e919290402880ce856ba7d922c758ffca703';
$headers = [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
];
$data = [
    'long_url' => $url,
    'domain' => 'bit.ly'
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response);
    $short_url = $data->link;
} else {
    die("Error: Could not connect to Bitly API");
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Century Gothic";
            background-color: #000;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        .qr-code-container {
            text-align: center;
        }
        .short-link, .long-link {
            text-align: center;
            margin-top: 20px;
        }
        .short-link a, .long-link a {
            color: #00f;
            text-decoration: none;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="qr-code-container">
        <div style="border: 5px solid white; border-radius: 6px; padding: 10px; margin: 20px;">
            <img src="data:image/png;base64,<?= base64_encode($qr_code_img); ?>" width="250" height="250"/>
        </div>
        <div class="long-link">
            <p>Scan this QR code to visit the URL:</p>
            <p><a href="<?= $url ?>"><?= $url ?></a></p>
        </div>
        <div class="short-link">
            <p>Your shortened URL:</p>
            <p><a href="<?= $short_url ?>"><?= $short_url ?></a></p>
        </div>
    </div>
</body>
</html>
