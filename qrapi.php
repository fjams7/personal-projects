<?php
    error_reporting(0);
?>
<html>
    <title>Link to QR Code</title>
<head>
</head>
    <style>
        body {
            text-align:center;
            background-color: #202f47;
            display: flex;
            justify-content: center; 
            align-items: center;
            height: 90vh;
        }
        input {
            width: 400px;
            padding: 10px 10px;
            margin: 4px 0;
            box-sizing: border-box;
            border: 3px solid gray;
            border-radius: 6px;
            font-size: 20px;
        }
        input[type=submit] {
            width: 100px;
            padding: 2px 4px;
            margin: 2px 0;
            box-sizing: border-box;
            border: 1px solid gray;
            border-radius: 6px; 
            font-size: 20px;
            background-color: #FFFFFF;
        }
        label {
            display: inline-block;
            width: 400px;
            font-size: 30px;
            text-align: left;
        }
        h1 {font-size: 30px;}
        #link {
            border: 1px black;
            border-radius: 10px;
            padding: 10px;
            color: black;
            box-sizing: border-box;
        }
        #main {
                border: 1px black;
                border-radius: 10px;
                background-color: #1c1c1c;
                padding: 100px;
                color: white;
                box-shadow: 10px 10px 10px black;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                height: 50vh;
            }
    </style>
</html>

<?php
$url = $_POST["link"];
$apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&color=FFFFFF&bgcolor=1c1c1c&data=".urlencode($url);
$qr_code_img = file_get_contents($apiUrl);

$api_url = 'https://api-ssl.bitly.com/v4/shorten';
$access_token = '6947e919290402880ce856ba7d922c758ffca703';
$headers = array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
);

$data = array(
    'long_url' => $url,
    'domain' => 'bit.ly'
);

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
        echo '
        <html>
        <head>
            <style>
                    body {
                        font-family:"century gothic";
                        background-color: #000000;
                        align-items: center;
                        flex-direction: column;
                        justify-content: center;
                        color: white;
                    } 
                    .container {
                        display: flex;
                        justify-content: center;
                        align-items: center; height: 100vh;
                        flex-direction: column;
                    }
                    .qr-code-container {
                        text-align: center;
                    }
                    .short-link {
                        text-align: center;
                        margin-top: 20px;
                    }
                    .short-link a {
                        color: #0000FF;
                        text-decoration: none;
                        font-size: 20px;
                        margin-top: 20px;
                    }
                    .long-link a {
                        color: #0000FF;
                        text-decoration: none;
                        font-size: 20px;
                        margin-top: 20px;
                    }
                </style>
            </head>
            <body>
                <div id="main">
                        <p>
                        <form method="POST" autocomplete="off">
                            <label for="link">Enter Link</label> <br>
                                <input type="url" name="link" id="link" required> <br>
                                <br><input type="submit" value="Submit">
                        </form>
                        </p><br> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <div class="container">
                            <div class="qr-code-container">
                            <div style="border: 5px solid white; border-radius: 6px;
                            padding: 10px; display: inline-block; margin: 20px;
                            height: 250px; width: 250px;">
                            <img src="data:image/png;base64,' . base64_encode($qr_code_img) . '"/>
                            </div>                        
                                <div class="long-link">
                                <p>Scan this QR code to visit the URL: </p>
                                <p><a href="' . $url . '">' . $url . '</a></p>
                                </div>
                            </div>
                        <div class="short-link">
                                <p>Your shortened URL:</p>
                                <p><a href="' . $short_url . '">' . $short_url . '</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>';
        } else {
            echo 'Error: Could not connect to Bitly API';
        }
?>