<?php

$addressData = $data->addresses($userAuth->user()->id());

$recAddress = $addressData->getRecordById($address_id);
if ($recAddress->id() < 0) {
    echo "Address Not Found";
    http_response_code(404);
    die();
}

// $billTypeData = $data->bill_types($recAddress->id());
// $recBillType = $billTypeData->getRecordById($billtype_id);
// if ($recBillType->id() < 0) {
//     echo "Bill Type Not Found";
//     http_response_code(404);
//     die();
// }

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($billtype_id)) {
            echo $data->bill_types($recAddress->id())->getRecordById($billtype_id)->toString();
        } else {
            $recs = [];
            foreach ($data->bill_types($recAddress->id())->getRecords() as $rec) {
                array_push($recs, json_decode($rec->toString()));
            }
            echo json_encode($recs);
        }
        break;
    case "POST":
        break;
    default:
        echo "Unknown Method";
        http_response_code(405);
        break;
}
