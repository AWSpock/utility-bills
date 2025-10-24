<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
	if ($userAuth->login($_POST['email'], $_POST['password'])) {
		// $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
		$host = $_SERVER['HTTP_HOST'];
		// $requestUri = $_SERVER['REQUEST_URI'];
		$requestUri = "";
		if (isset($_GET['redirect']))
			$requestUri = $_GET['redirect'];
		// $currentUrl = $protocol . '://' . $host . $requestUri;
		$currentUrl =  'https://' . $host . $requestUri;
		header('Location: ' . $currentUrl);
		die();
	}
}
