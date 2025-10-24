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

$billTypeData = $data->bill_types($recAddress->id());
$recBillType = $billTypeData->getRecordById($billtype_id);
if ($recBillType->id() < 0) {
    header('Location: /address/' . $recAddress->id() . '/bill-type');
    die();
}

$recBillType->store_bills($data->bills($recAddress->id(), $recBillType->id())->getRecords());

//

if (!empty($_POST)) {
    $res = $billTypeData->deleteRecord($recBillType->id());
    $_SESSION['last_message_text'] = $billTypeData->actionDataMessage;
    if ($res == 1) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/bill-type');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}
?>