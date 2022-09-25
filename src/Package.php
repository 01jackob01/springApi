<?php

namespace Src;

use ApiData\NewPackage;
use ApiData\PackagePDF;
use Exception;

class Package
{
    /**
     * @var string
     */
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @throws Exception
     */
    public function newPackage(array $order, array $params)
    {
        NewPackage::validateNewPackageData($params, $order, $this->apiKey);

        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => "https://mtapi.net/?testMode=1",
                CURLOPT_POST => '1',
                CURLOPT_HEADER => "0",
                CURLOPT_POSTFIELDS => $this->createNewPackagePostData($params, $order)
            ]
        );

        curl_exec($ch);
    }

    public function packagePDF(string $trackingNumber)
    {
        PackagePDF::validatePackagePDFData($trackingNumber, $this->apiKey);

        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => "https://mtapi.net/?testMode=1",
                CURLOPT_POST => '1',
                CURLOPT_HEADER => "0",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POSTFIELDS => $this->createPackagePDFPostData($trackingNumber)
            ]
        );
        $response = curl_exec($ch);

        $this->createLabelPDF($response, $trackingNumber);
    }

    public function createLabelPDF(string $response, string $trackingNumber)
    {
        $file = TEMP_FILES . "label_" . $trackingNumber . ".pdf";
        $decodedResponse = json_decode($response);
        if ($decodedResponse->ErrorLevel === 0) {
            $myfile = fopen($file, "w");
            fwrite($myfile, base64_decode($decodedResponse->Shipment->LabelImage));
            fclose($myfile);

            header("Content-type: application/pdf");
            header("Content-Length: " . filesize($file));
            readfile($file);
        } else {
            echo json_encode([
                'ErrorLevel' => $decodedResponse->ErrorLevel,
                'Error'      => $decodedResponse->Error,
            ]);
        }
    }

    public function createNewPackagePostData(array $params, array $order)
    {
        $shipmentData["Apikey"] = $this->apiKey;
        $shipmentData["Command"] = "OrderShipment";
        foreach ($params as $key => $val) {
            if ($key = 'api_key') {
                continue;
            }
            $shipmentData['Shipment'][NewPackage::getShipmentApiName($key)] = $val;
        }
        foreach ($order as $key => $val) {
            $type = explode("_", $key);
            if ($type[0] == 'sender') {
                $shipmentData['Shipment']['ConsignorAddress'][NewPackage::getSenderApiName($key)] = $val;
            } elseif ($type[0] == 'delivery') {
                $shipmentData['Shipment']['ConsigneeAddress'][NewPackage::getDeliveryApiName($key)] = $val;
            }
        }

        return json_encode($shipmentData);
    }

    public function createPackagePDFPostData(string $trackingNumber)
    {
        $packagePDF['Apikey'] = $this->apiKey;
        $packagePDF['Command'] = 'GetShipmentLabel';
        $packagePDF['Shipment']['LabelFormat'] = 'PDF';
        $packagePDF['Shipment']['TrackingNumber'] = $trackingNumber;

        return json_encode($packagePDF);
    }
}