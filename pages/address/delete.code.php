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

$recAddress->store_bill_types($data->bill_types($recAddress->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $addressData->deleteRecord($recAddress->id());
    $_SESSION['last_message_text'] = $addressData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>