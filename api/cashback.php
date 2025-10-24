<?php

include_once("/var/www/cashback/php/data/CashBackMapper.php");

$mapper = new CashBackMapper($userAuth->user()->id());

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['id'])) {
    echo json_encode($mapper->getRecord($_GET['id']));
} else {
    echo json_encode($mapper->getRecords());
}
