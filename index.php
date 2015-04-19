<?php

require 'vendor/autoload.php';

// Get metro status page
$http = new GuzzleHttp\Client();
$response = $http->get('http://app.metrolisboa.pt/status/estado_Linhas.php');

// Parse status page
$dom = new PHPHtmlParser\Dom();
$dom->load($response->getBody());
$text_status = $dom->find('li');

$line_status = array(
	'yellow' => $text_status[0]->text,
	'blue'   => $text_status[1]->text,
	'green'  => $text_status[2]->text,
	'red'    => $text_status[3]->text,
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
			display: flex;
		}

		.line {
			flex: 1;
			height: 50vh;
			color: #FFF;
			font-size: 2em;
			padding-top: 1em;
			padding-left: 1em;
			box-sizing: border-box;
		}

		.yellow { background-color: #FDB813; }
		.blue   { background-color: #4E84C4; }
		.green  { background-color: #00A9A6; }
		.red    { background-color: #ED2B74; }

		@media only screen and (orientation: portrait) {
			.row {
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
			<div class="line yellow"><?php echo $line_status['yellow']; ?></div>
			<div class="line blue"><?php echo $line_status['blue']; ?></div>
		</div>

		<div class="row">
			<div class="line green"><?php echo $line_status['green']; ?></div>
			<div class="line red"><?php echo $line_status['red']; ?></div>
		</div>
	</main>
</body>
</html>