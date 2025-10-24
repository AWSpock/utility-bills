<?php

$addressData = $data->addresses($userAuth->user()->id());

$addresses = $data->addresses($userAuth->user()->id())->getRecords();
