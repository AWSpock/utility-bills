<?php

include_once("/var/www/utility-bills/php/utilities/Common.php");
include_once("/var/www/utility-bills/php/utilities/RouteParser.php");

include_once("/var/www/utility-bills/php/DataAccess/UserAuth.php");
include_once("/var/www/utility-bills/php/DataAccess/DataAccess.php");

$userAuth = new UserAuth();
$routeParser = new RouteParser("api");
$data = new DataAccess();
session_start();

error_log("TEST",0);

switch ($routeParser->ResourcePath()) {
    case "/public":
        break;
    default:
        if (!$userAuth->checkToken() || !$userAuth->checkUtility()) {
            http_response_code(401);
            echo "Unauthorized";
            die();
        }

        $uriparts = explode("/", $_SERVER['REQUEST_URI']);
        if (array_key_exists(2, $uriparts))
            $address_id = explode("/", $_SERVER['REQUEST_URI'])[3];
        if (array_key_exists(4, $uriparts))
            $billtype_id = explode("/", $_SERVER['REQUEST_URI'])[5];
        if (array_key_exists(6, $uriparts))
            $bill_id = explode("/", $_SERVER['REQUEST_URI'])[7];
        break;
}

error_log("Path: " . $routeParser->PagePath(), 0);

if (file_exists($routeParser->PagePath())) {
    try {
        header('Content-Type: application/json; charset=utf-8');
        require $routeParser->PagePath();
    } catch (DatabaseException $ex) {
        http_response_code(500);
        error_log("Database Error: " . $ex->getMessage(), 0);
        echo "Database Error: " . $ex->getMessage();
        die();
    } catch (Exception $ex) {
        http_response_code(500);
        error_log("Other Error: " . $ex->getMessage(), 0);
        echo "Other Error: " . $ex->getMessage();
        die();
    } catch (Throwable $ex) {
        http_response_code(500);
        error_log("Major Error: " . $ex->getMessage(), 0);
        echo "Major Error: " . $ex->getMessage();
        die();
    }
} else {
    http_response_code(404);
    echo "Not Found";
}
