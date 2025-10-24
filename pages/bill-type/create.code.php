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

$recBillType = new BillType();

// 

if (!empty($_POST)) {
    $billTypeData = $data->bill_types($recAddress->id());
    $recBillType = BillType::fromPost($_POST);
    $billtype_id = $billTypeData->insertRecord($recBillType);
    $_SESSION['last_message_text'] = $billTypeData->actionDataMessage;
    if ($billtype_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/bill-type');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
