<?php

$addressData = $data->addresses($userAuth->user()->id());

$recAddress = $addressData->getRecordById($address_id);
if ($recAddress->id() < 0) {
    header('Location: /');
    die();
}

$billTypeData = $data->bill_types($recAddress->id());
$recBillType = $billTypeData->getRecordById($billtype_id);
if ($recBillType->id() < 0) {
    header('Location: /address/' . $recAddress->id() . '/bill-type');
    die();
}

$recBill = new Bill();

// 

if (!empty($_POST)) {
    $billData = $data->bills($recAddress->id(), $recBillType->id());
    $recBill = Bill::fromPost($_POST);
    $bill_id = $billData->insertRecord($recBill);
    $_SESSION['last_message_text'] = $billData->actionDataMessage;
    if ($bill_id > 0) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/bill-type/' . $recBillType->id() . "/bill");
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
