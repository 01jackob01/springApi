<?php

class NewPackage
{
    const SHIPMENT_COMMANDS = [
        "label_format"      => ["apiName" => "LabelFormat", "required" => false],
        "shipper_reference" => ["apiName" => "ShipperReference", "required" => true],
        "order_reference"   => ["apiName" => "OrderReference", "required" => false],
        "display_id"        => ["apiName" => "DisplayId", "required" => false],
        "service"           => ["apiName" => "Service", "required" => true],
        "weight"            => ["apiName" => "Weight", "required" => true],
        "weight_unit"       => ["apiName" => "WeightUnit", "required" => false],
        "length"            => ["apiName" => "Length", "required" => false],
        "width"             => ["apiName" => "Width", "required" => false],
        "height"            => ["apiName" => "Height", "required" => false],
        "dim_unit"          => ["apiName" => "DimUnit", "required" => false],
        "value"             => ["apiName" => "Value", "required" => false],
        "shipping_value"    => ["apiName" => "ShippingValue", "required" => false],
        "currency"          => ["apiName" => "Currency", "required" => false],
        "customs_duty"      => ["apiName" => "CustomsDuty", "required" => false],
        "description"       => ["apiName" => "Description", "required" => false],
        "declaration_type"  => ["apiName" => "DeclarationType", "required" => false],
        "dangerous_goods"   => ["apiName" => "DangerousGoods", "required" => false],
    ];

    const CONSIGNOR_ADDRESS_COMMANDS = [
        "sender_fullname"   => ["apiName" => "Name", "required" => false],
        "sender_company"    => ["apiName" => "Company", "required" => false],
        "sender_address"    => ["apiName" => "AddressLine1", "required" => false],
        "sender_address_2"  => ["apiName" => "AddressLine2", "required" => false],
        "sender_address_3"  => ["apiName" => "AddressLine3", "required" => false],
        "sender_city"       => ["apiName" => "City", "required" => false],
        "sender_state"      => ["apiName" => "State", "required" => false],
        "sender_postalcode" => ["apiName" => "Zip", "required" => false],
        "sender_country"    => ["apiName" => "Country", "required" => false],
        "sender_phone"      => ["apiName" => "Phone", "required" => false],
        "sender_email"      => ["apiName" => "Email", "required" => false],
        "sender_vat"        => ["apiName" => "Vat", "required" => false],
        "sender_eori"       => ["apiName" => "Eori", "required" => false],
        "sender_nl_vat"     => ["apiName" => "NlVat", "required" => false],
        "sender_eu_eori"    => ["apiName" => "EuEori", "required" => false],
        "sender_ioss"       => ["apiName" => "Ioss", "required" => false],
    ];

    const CONSIGNEE_ADDRESS_COMMANDS = [
        "delivery_fullname"         => ["apiName" => "Name", "required" => true],
        "delivery_company"          => ["apiName" => "Company", "required" => false],
        "delivery_address"          => ["apiName" => "AddressLine1", "required" => true],
        "delivery_address_2"        => ["apiName" => "AddressLine2", "required" => false],
        "delivery_address_3"        => ["apiName" => "AddressLine3", "required" => false],
        "delivery_city"             => ["apiName" => "City", "required" => true],
        "delivery_state"            => ["apiName" => "State", "required" => false],
        "delivery_postalcode"       => ["apiName" => "Zip", "required" => false],
        "delivery_country"          => ["apiName" => "Country", "required" => true],
        "delivery_phone"            => ["apiName" => "Phone", "required" => true],
        "delivery_email"            => ["apiName" => "Email", "required" => true],
        "delivery_vat"              => ["apiName" => "Vat", "required" => false],
        "delivery_pudo_location_id" => ["apiName" => "PudoLocationId", "required" => false],
    ];

    public static function getAllRequiredValue(string $type): array
    {
        $requiredValues = [];
        $dataToCheck = [];

        switch ($type) {
            case 'shipment':
                $dataToCheck = self::SHIPMENT_COMMANDS;
                break;
            case 'sender':
                $dataToCheck = self::CONSIGNOR_ADDRESS_COMMANDS;
                break;
            case 'delivery':
                $dataToCheck = self::CONSIGNEE_ADDRESS_COMMANDS;
                break;
        }

        foreach ($dataToCheck as $key => $data) {
            if ($data['required']) {
                $requiredValues[] = $key;
            }
        }

        return $requiredValues;
    }

    public static function getAllShipmentOptions()
    {
        return self::SHIPMENT_COMMANDS;
    }

    public static function getShipmentApiName($key)
    {
        return self::SHIPMENT_COMMANDS[$key]['apiName'];
    }

    public static function getAllSenderOptions()
    {
        return self::CONSIGNOR_ADDRESS_COMMANDS;
    }

    public static function getSenderApiName($key)
    {
        return self::CONSIGNOR_ADDRESS_COMMANDS[$key]['apiName'];
    }

    public static function getAllDeliveryOptions()
    {
        return self::CONSIGNEE_ADDRESS_COMMANDS;
    }

    public static function getDeliveryApiName($key)
    {
        return self::CONSIGNEE_ADDRESS_COMMANDS[$key]['apiName'];
    }

    public static function validateNewPackageData(array $params, array $order, string $apiKey)
    {
        try {
            CheckApiKey::checkApiKeyValue($apiKey);
            NewPackage::validateShipmentData($params);
            NewPackage::validateOrderData($order);
        } catch (Exception $e) {
            echo json_encode([
                'Error code'    => $e->getCode(),
                'Error message' => $e->getMessage()
            ]);
            die;
        }
    }

    private static function validateShipmentData($params)
    {
        $requiredShipmentData = NewPackage::getAllRequiredValue('shipment');

        foreach ($requiredShipmentData as $requiredKey) {
            if (!array_key_exists($requiredKey, $params)) {
                throw new Exception("Required value '" . $requiredKey . "' in 'Shipment Object' not found", 400);
            }
        }
        foreach ($params as $key => $val) {
            if (!NewPackage::getShipmentApiName($key) && $key != 'api_key') {
                throw new Exception("Invalid value '" . $key . "' in 'Shipment Object'", 400);
            }
        }
    }

    private static function validateOrderData($order)
    {
        $requiredSenderData = NewPackage::getAllRequiredValue('sender');
        $requiredDeliveryData = NewPackage::getAllRequiredValue('delivery');

        foreach ($requiredSenderData as $requiredKey) {
            if (!array_key_exists($requiredKey, $order)) {
                throw new Exception("Required value '" . $requiredKey . "' in 'ConsignorAddress Object' not found", 400);
            }
        }

        foreach ($requiredDeliveryData as $requiredKey) {
            if (!array_key_exists($requiredKey, $order)) {
                throw new Exception("Required value '" . $requiredKey . "' in 'ConsigneeAddress Object' not found", 400);
            }
        }

        foreach ($order as $key => $val) {
            $type = explode("_", $key);
            if ($type[0] == 'sender') {
                if (!NewPackage::getSenderApiName($key)) {
                    throw new Exception("Invalid value '" . $key . "' in 'ConsignorAddress Object'", 400);
                }
            } elseif ($type[0] == 'delivery') {
                if (!NewPackage::getDeliveryApiName($key)) {
                    throw new Exception("Invalid value '" . $key . "' in 'ConsignorAddress Object'", 400);
                }
            } else {
                throw new Exception("Invalid value '" . $key, 400);
            }
        }
    }
}