<?php
error_reporting(0);
session_start();
	$text = $_SESSION['extracted_text'];
	$curl = curl_init($text);
	$lang = $_POST['opt1'];
	$trans = $_POST['opt2'];

	$option1; $option2;

	if($_POST['opt1'] == "en"){
		$option1 = "English";
	}
	if($_POST['opt1'] == "tl"){
		$option1 = "Tagalog";
	}
	if($_POST['opt1'] == "ceb"){
		$option1 = "Cebuano";
	}
	if($_POST['opt1'] == "zh-CN"){
		$option1 = "Chinese";
	}
	if($_POST['opt1'] == "fr"){
		$option1 = "French";
	}
	if($_POST['opt1'] == "ja"){
		$option1 = "Japanese";
	}
	if($_POST['opt1'] == "es"){
		$option1 = "Spanish";
	}

	if($_POST['opt2'] == "en"){
		$option2 = "English";
	}
	if($_POST['opt2'] == "tl"){
		$option2 = "Tagalog";
	}
	if($_POST['opt2'] == "ceb"){
		$option2 = "Cebuano";
	}
	if($_POST['opt2'] == "zh-CN"){
		$option2 = "Chinese";
	}
	if($_POST['opt2'] == "fr"){
		$option2 = "French";
	}
	if($_POST['opt2'] == "ja"){
		$option2 = "Japanese";
	}
	if($_POST['opt2'] == "es"){
		$option2 = "Spanish";
	}

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://rapid-translate-multi-traduction.p.rapidapi.com/t",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\r\n    \"from\": \"$lang\",\r\n    \"to\": \"$trans\",\r\n    \"q\": \"$text\"\r\n}",
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: rapid-translate-multi-traduction.p.rapidapi.com",
			"X-RapidAPI-Key: ", //API Key
			"content-type: application/json"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
	echo('<style> 
			html {font-family:"century gothic";}
			body {
				font-family:"century gothic";
				text-align:left; 
				background-color: #F5EDDD;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				height: 97vh;
				color: white;
			}
			textarea {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				border-radius: 10px;
				font-size: 15px;
				width: 500px;
				height: 250px;
				resize: none;
				padding: 10px;
				background-color: #FFFFFF;
			}
			input[type=submit] {
				width: 100px;
				height: 25px;
				padding: 0.01px 3px;
				box-sizing: border-box;
				border: 1px solid gray;
				border-radius: 6px; 
				font-size: 20px;
				background-color: #FFFFFF;
				text-align:center;
				display: block;
				margin: 0 auto;
			}
			#container {
				border: 1px black;
				border-radius: 10px;
				background-color: #1C1C1C;
				padding: 30px;
				color: white;
				box-shadow: 10px 10px 5px black;
			}
		</style>');
	echo '<div id="container">';
	echo "<h2>$option1</h2>";
	echo "<textarea readonly>";
	echo "$text";
	echo "</textarea>";
	echo "<br>";

	echo "<h2>$option2</h2>";
	echo "<textarea readonly>";
	$response_array = json_decode($response, true);
	$translated_text = $response_array[0];
	if (!empty($response_array)) {
		echo $translated_text;
		echo "</textarea>";
	} else {
		echo "<br>max quota reached.";
	}

	echo '<form action="ocr_sample.php">';
	echo '<br>';
	echo '<input type="submit" value="Go Back">';
	echo '</form>';
	echo '</div>';
	}
?>