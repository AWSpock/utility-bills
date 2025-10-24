<?php
include_once("/var/www/utility-bills/php/data/UserAuth.php");

$userAuth = new UserAuth();

if (!$userAuth->checkToken() || !$userAuth->checkUtility()) {
    echo "Unauthorized";
    die();
}

$apiDir = "/api";
$siteDir = $_SERVER['DOCUMENT_ROOT'];

$request = $_SERVER['REDIRECT_URL'];
$requestParts = explode("/", $request);

switch ($request) {
    case "/api/cash_back":
        $pagePath = "/cashback.php";
        break;
}

if ($pagePath != "") {
    $fileExists = true;
    $pagePath = $siteDir . $apiDir . $pagePath;
}

if ($fileExists) {
    try {
        require $pagePath;
    } catch (Exception $ex) {
        http_response_code(500);
        echo "Error: " . $ex->getMessage();
        // header("Location: /error?message=" . $ex->getMessage() . "&route=" . urlencode($request));
        die();
    }
} else {
    http_response_code(404);
    echo "Not Found";
    // require $siteDir . $viewDir . "/404.php";
}
