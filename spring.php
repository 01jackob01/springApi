<?php

require 'vendor/autoload.php';
use Src\Package;
use ApiData\NewPackage;

define("TEMP_FILES", "tmpFile/");

if (isset($_GET['www_request'])) {
    $params['api_key'] = '<api_key>';
    if ($_GET['api'] == 'new_package') {
        foreach (NewPackage::SHIPMENT_COMMANDS as $key => $option) {
            if (isset($_GET[$key]) && !empty($_GET[$key])) {
                $params[$key] = $_GET[$key];
            }
        }
        foreach (NewPackage::CONSIGNOR_ADDRESS_COMMANDS as $key => $option) {
            if (isset($_GET[$key]) && !empty($_GET[$key])) {
                $order[$key] = $_GET[$key];
            }
        }
        foreach (NewPackage::CONSIGNEE_ADDRESS_COMMANDS as $key => $option) {
            if (isset($_GET[$key]) && !empty($_GET[$key])) {
                $order[$key] = $_GET[$key];
            }
        }
    } elseif ($_GET['api'] == 'get_label') {
        $trackingNumber = $_GET['tracking_number'];
    }

} else {
    $order = [
        'sender_company'    => 'BaseLinker',
        'sender_fullname'   => 'Jan Kowalski',
        'sender_address'    => 'Kopernika 10',
        'sender_city'       => 'Gdansk',
        'sender_postalcode' => '80208',
        'sender_email'      => '',
        'sender_phone'      => '666666666',

        'delivery_company'    => 'Spring GDS',
        'delivery_fullname'   => 'Maud Driant',
        'delivery_address'    => 'Strada Foisorului, Nr. 16, Bl. F11C, Sc. 1, Ap. 10',
        'delivery_city'       => 'Bucuresti, Sector 3',
        'delivery_postalcode' => '031179',
        'delivery_country'    => 'RO',
        'delivery_email'      => 'john@doe.com',
        'delivery_phone'      => '555555555',
    ];

    $params = [
        'api_key'           => '<api_key>',
        'label_format'      => 'PDF',
        'service'           => 'PPTT',
        'shipper_reference' => uniqid(),
        'description'       => 'Opis produktu',
        'value'             => '50',
        'weight'            => '1'
    ];

    $trackingNumber = 'LS004492314NL';
}

$package = new Package($params['api_key']);
if ($_GET['api'] == 'new_package') {
    $package->newPackage($order, $params);
} elseif ($_GET['api'] == 'get_label') {
    $package->packagePDF($trackingNumber);
} elseif ($_GET['api'] == 'get_default_values') {
    $defaultValues = ['params' => $params, 'order' => $order];
} else {
    echo json_encode([
        'ErrorLevel' => 404,
        'Error'      => 'Wrong API',
    ]);
}

// 1. Create courier object
// 2. Create shipment
// 3. Get shipping label and force a download dialog

