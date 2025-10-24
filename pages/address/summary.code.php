<?php

$addressData = $data->addresses($userAuth->user()->id());
$addresses = $addressData->getRecords();

$recAddress = $addressData->getRecordById($address_id);
if ($recAddress->id() < 0) {
    header('Location: /');
    die();
}

$recAddress->store_bill_types($data->bill_types($recAddress->id())->getRecords());

foreach ($recAddress->bill_types() as $recBillType) {
    $recBillType->store_bills($data->bills($recAddress->id(), $recBillType->id())->getRecords());
}

//

if (!empty($_POST['address_favorite'])) {
    $res = 0;
    switch ($_POST['address_favorite']) {
        case "Yes":
            $res = $addressData->setFavorite($recAddress->id());
            break;
        case "No":
            $res = $addressData->removeFavorite($recAddress->id());
            break;
    }
    $_SESSION['last_message_text'] = $addressData->actionDataMessage;
    if ($res === true) {
        $_SESSION['last_message_type'] = "success";
        header('Location: /address/' . $recAddress->id() . '/summary');
        die();
    } else {
        $_SESSION['last_message_type'] = "danger";
    }
}

function returnPercentage($value, $min = 0, $max = 100)
{
    if ($max - $min > 0) {
        $interval = 100 / ($max - $min);
        $percent = ($value - $min) * $interval;
        return round($percent / 2, 2) / 100;
    }
    return 0;
}
