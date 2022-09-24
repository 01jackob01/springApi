<?php

class PackagePDF
{
    const SHIPMNET_COMMANDS = [
        'label_format'      => ["apiName" => "LabelFormat", "required" => false],
        'tracking_Number'   => ["apiName" => "TrackingNumber", "required" => false],
        'shipper_reference' => ["apiName" => "ShipperReference", "required" => false],
    ];

    public static function validatePackagePDFData(string $trackingNumber, string $apiKey)
    {
        try {
            CheckApiKey::checkApiKeyValue($apiKey);
        } catch (Exception $e) {
            echo json_encode([
                'Error code'    => $e->getCode(),
                'Error message' => $e->getMessage()
            ]);
            die;
        }
    }
}