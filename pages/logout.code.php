<?php

if ($userAuth->checkToken()) {
	if ($userAuth->logout()) {
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
		$host = $_SERVER['HTTP_HOST'];
		$requestUri = $_SERVER['REQUEST_URI'];
		$currentUrl = $protocol . '://' . $host . $requestUri;
		header('Location: ' . $currentUrl);
		die();
	}
}
