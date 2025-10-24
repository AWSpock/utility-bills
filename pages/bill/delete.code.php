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

$billData = $data->bills($recAddress->id(), $recBillType->id());
$recBill = $billData->getRecordById($bill_id);
if ($recBill->id() < 0) {
    header('Location: /address/' . $recAddress->id() . '/bill-type/' . $recBillType->id() . '/bill');
    die();
}

//

if (!empty($_POST)) {
    $res = $billData->deleteRecord($recBill);
    $_SESSION['last_message_text'] = $billData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/bill-type/' . $recBillType->id() . '/bill');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
