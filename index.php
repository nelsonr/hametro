<?php

require 'vendor/autoload.php';

// Get metro status page
$http = new GuzzleHttp\Client();
$response = $http->get('http://app.metrolisboa.pt/status/estado_Linhas.php');

// Parse status page
$dom = new PHPHtmlParser\Dom();
$dom->load($response->getBody());
$text_status = $dom->find('ul');

$line_status = array(
	'yellow' => array('message' => $text_status[0]->find('li')->text, 'status' => $text_status[0]->getAttribute('class')),
	'blue' 	 => array('message' => $text_status[1]->find('li')->text, 'status' => $text_status[1]->getAttribute('class')),
	'green'  => array('message' => $text_status[2]->find('li')->text, 'status' => $text_status[2]->getAttribute('class')),
	'red' 	 => array('message' => $text_status[3]->find('li')->text, 'status' => $text_status[3]->getAttribute('class')),
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Há Metro?</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="apple-touch-icon" href="apple-touch-icon@2x.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon@3x.png" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	<style>
		html, body {
			margin: 0;
			padding: 0;
			font-family: sans-serif;
		}

		.row {
			display: -webkit-flex;
			display: flex;
		}

		.line {
			-webkit-flex: 1;
			flex: 1;
			height: 50vh;
			color: #FFF;
			font-size: 2em;
			padding: 2rem;
			box-sizing: border-box;
		}

		.comperturbacao {
			font-size: 1em;
		}

		.yellow { background-color: #FDB813; }
		.blue   { background-color: #4E84C4; }
		.green  { background-color: #00A9A6; }
		.red    { background-color: #ED2B74; }

		@media only screen and (orientation: portrait) {
			.row {
				-webkit-flex-direction: column;
				flex-direction: column;
			}

			.line {
				height: 25vh;
			}
		}
	</style>
</head>
<body>
	<main>
		<div class="row">
			<div class="line yellow <?php echo $line_status['yellow']['status']; ?>"><?php echo $line_status['yellow']['message']; ?></div>
			<div class="line blue <?php echo $line_status['yellow']['status']; ?>"><?php echo $line_status['blue']['message']; ?></div>
		</div>

		<div class="row">
			<div class="line green <?php echo $line_status['yellow']['status']; ?>"><?php echo $line_status['green']['message']; ?></div>
			<div class="line red <?php echo $line_status['yellow']['status']; ?>"><?php echo $line_status['red']['message']; ?></div>
		</div>
	</main>
</body>
</html>
