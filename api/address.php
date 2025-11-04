<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($address_id)) {
            echo $data->addresses($userAuth->user()->id())->getRecordById($address_id)->toString();
        } else {
            $recs = [];
            foreach ($data->addresses($userAuth->user()->id())->getRecords() as $rec) {
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
