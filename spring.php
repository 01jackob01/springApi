<?php

define("TEMP_FILES", "tmpFile/");

spl_autoload_register(function ($class_name) {
    include_once 'src/' . $class_name . '.php';
    include_once 'apiData/' . $class_name . '.php';
});

if (isset($_REQUEST['www_request'])) {
    $params['api_key'] = '<api_key>';
    if ($_REQUEST['api'] == 'new_package') {
        foreach (NewPackage::SHIPMENT_COMMANDS as $key => $option) {
            if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                $params[$key] = $_REQUEST[$key];
            }
        }
        foreach (NewPackage::CONSIGNOR_ADDRESS_COMMANDS as $key => $option) {
            if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                $order[$key] = $_REQUEST[$key];
            }
        }
        foreach (NewPackage::CONSIGNEE_ADDRESS_COMMANDS as $key => $option) {
            if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                $order[$key] = $_REQUEST[$key];
            }
        }
    } elseif ($_REQUEST['api'] == 'get_label') {
        $trackingNumber = $_REQUEST['tracking_number'];
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
if ($_REQUEST['api'] == 'new_package') {
    $package->newPackage($order, $params);
} elseif ($_REQUEST['api'] == 'get_label') {
    $package->packagePDF($trackingNumber);
} elseif ($_REQUEST['api'] == 'get_default_values') {
    $defaultValues = ['params' => $params, 'order' => $order];
} else {
    echo 'Wrong API';
}

// 1. Create courier object
// 2. Create shipment
// 3. Get shipping label and force a download dialog

