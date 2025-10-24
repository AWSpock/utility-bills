<?php

$recAddress = new Address();

// 

if (!empty($_POST)) {
    $data = new DataAccess();
    $addressData = $data->addresses($userAuth->user()->id());

    $recAddress = Address::fromPost($_POST);
    $address_id = $addressData->insertRecord($recAddress);
    $_SESSION['last_message_text'] = $addressData->actionDataMessage;
    if ($address_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $address_id . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
