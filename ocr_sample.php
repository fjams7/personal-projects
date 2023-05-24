<html>
<head>
	<title>OCR/Translator API</title>
</head>
<style>
        body {
            font-family:"century gothic";
            text-align:left; 
            height: 95vh;
            background-color: #F5EDDD;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }
        input[type=file]{
            width: 80%;
            padding: 10px 10px;
            margin: 4px 0;
            box-sizing: border-box;
            border: 1px solid gray;
            border-radius: 10px;
            font-size: 15px;
            text-align:left;
            color: white;
            background-color: #202f47;
        }

        input[value='Extract Text'] {
            padding: 8px 10px;
            width: 20%;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px white;
            border-radius: 10px;
            font-size: 15px;
            text-align:center;
            color: black;
            background-color;
        }
        input[value=Submit] {
            width: 100px;
            height: 27px;
            padding: 0.01px 3px;
            box-sizing: border-box;
            border: 2px white;
            border-radius: 10px; 
            font-size: 15px;
            background-color: #FFFFFF;
            text-align:center;
            color: black;
            background-color;
        }
        select {
            box-sizing: border-box;
            height: 25px;
            width: 100px;
            display: inline-block;
            text-align: left;
            border: 2px white;
            border-radius: 10px;
            color: black;
            background-color: #FFFFFF;
            font-size: 15px;
        }
        h1 {
            font-size: 30px;
            color: white;
        }
        textarea {
            border-radius: 10px;
            font-size: 15px;
            width: 600px;
            height: 250px;
            resize: none;
            padding: 10px;
        }
        text {
            font-size: 20px;
        }
        #container {
            border: 1px black;
            border-radius: 10px;
            background-color: #1C1C1C;
            padding: 30px;
            color: white;
            box-shadow: 10px 10px 5px black;
        }
        input[type="file"] {
            padding: 5px 10px;
            width: 76%;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px white;
            border-radius: 10px;
            font-size: 15px;
            text-align:right;
            color: black;
            background-color: #FFFFFF;
        }
    </style>
<body>
    <div id='container'>

    <h1> OCR/Translator API <hr> </h1>
            <form action="" method="post" enctype="multipart/form-data">
		        <input type="file" name="image" accept="image/*">
                &nbsp&nbsp
		        <input type="submit" value="Extract Text">
            </form>
    <h2>Extracted Text: </h2>
	<?php
        error_reporting(0);
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['extracted_text']);
        }
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$file = $_FILES['image'];
			$fileName = $file['name'];
			$fileType = $file['type'];
			$fileTmpName = $file['tmp_name'];
			$fileError = $file['error'];
			$fileSize = $file['size'];

			$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
			$detectedType = exif_imagetype($fileTmpName);
			if (!in_array($detectedType, $allowedTypes)) {
				echo "Error: Uploaded file is not an image";
				exit();
			}

			$imageData = file_get_contents($fileTmpName);

			$requestData = array(
				"requests" => array(
					array(
						"image" => array(
							"content" => base64_encode($imageData)
						),
						"features" => array(
							array(
								"type" => "TEXT_DETECTION"
							)
						)
					)
				)
			);

			$curl = curl_init();
            $api_key = ""; //API Key
			curl_setopt($curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=$api_key");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData));
			$response = curl_exec($curl);
			curl_close($curl);

			$json = json_decode($response, true);
			$text = $json['responses'][0]['fullTextAnnotation']['text'];
		}
        session_start();
        $_SESSION['extracted_text'] = $text;
        echo "<textarea readonly>$text</textarea>";
	?>
    <form action="translate_sample.php" method="POST">
            <br>Select Language: <tab>
            <label for="opt1" required> </label>
            <select id="opt1" name="opt1">
                <option value="en"> English </option>
                <option value="tl"> Tagalog </option>
                <option value="ceb"> Cebuano </option>
                <option value="zh-CN"> Chinese </option>
                <option value="fr"> French </option>
                <option value="ja"> Japanese </option>
                <option value="es"> Spanish </option>
            </select>
            &nbsp&nbsp&nbsp
            <tab> Translate to: <tab>
            <label for="opt2" required> </label>
            <select id="opt2" name="opt2">
                <option value="en"> English </option>
                <option value="tl"> Tagalog </option>
                <option value="ceb"> Cebuano </option>
                <option value="zh-CN"> Chinese </option>
                <option value="fr"> French </option>
                <option value="ja"> Japanese </option>
                <option value="es"> Spanish </option>
            </select>
            <tab>&nbsp&nbsp&nbsp&nbsp&nbsp <input type="submit" value="Submit">
    </div>
</body>
</html>