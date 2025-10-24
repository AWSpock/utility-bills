<?php

$addressData = $data->addresses($userAuth->user()->id());

$recAddress = $addressData->getRecordById($address_id);
if ($recAddress->id() < 0) {
    header('Location: /');
    die();
}
if (!$recAddress->isOwner()) {
    header('Location: /address/' . $recAddress->id() . '/summary');
    die();
}

//

if (!empty($_POST)) {
    $recAddress = Address::fromPost($_POST);
    $res = $addressData->updateRecord($recAddress);
    $_SESSION['last_message_text'] = $addressData->actionDataMessage;
    if ($res == 1 || $res == 2) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
