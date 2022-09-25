<?php declare(strict_types=1);

use ApiData\NewPackage;
use PHPUnit\Framework\TestCase;

final class NewPackageTest extends TestCase
{
    /**
     * @covers NewPackage::getAllRequiredValue
     */
    public function testGetAllRequiredValueForShipment()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllRequiredValue('shipment');

        /**
         * Expected data
         */
        $expectedData = [
            "shipper_reference",
            "service",
            "weight",
        ];

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::getAllRequiredValue
     */
    public function testGetAllRequiredValueForSender()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllRequiredValue('sender');

        /**
         * Expected data
         */
        $expectedData = [];

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::getAllRequiredValue
     */
    public function testGetAllRequiredValueForDelivery()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllRequiredValue('delivery');

        /**
         * Expected data
         */
        $expectedData = [
            "delivery_fullname",
            "delivery_address",
            "delivery_city",
            "delivery_country",
            "delivery_phone",
            "delivery_email",
        ];

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::getAllShipmentOptions
     */
    public function testGetAllShipmentOptions()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllShipmentOptions();

        /**
         * Expected data
         */
        $expectedData = [
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

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::getAllSenderOptions
     */
    public function testGetAllSenderOptions()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllSenderOptions();

        /**
         * Expected data
         */
        $expectedData = [
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

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::getAllDeliveryOptions
     */
    public function testGetAllDeliveryOptions()
    {
        /**
         * Execute
         */
        $allSenderOptions = NewPackage::getAllDeliveryOptions();

        /**
         * Expected data
         */
        $expectedData = [
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

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $allSenderOptions);
    }

    /**
     * @covers NewPackage::validateShipmentData
     */
    public function testValidateShipmentData()
    {
        /**
         * Insert data
         */
        $params = [
            'api_key'           => '<api_key>',
            'label_format'      => 'PDF',
            'service'           => 'PPTT',
            'shipper_reference' => uniqid(),
            'description'       => 'Opis produktu',
            'value'             => '50',
            'weight'            => '1'
        ];

        /**
         * Execute
         */
        $allSenderOptions = NewPackage::validateShipmentData($params);

        /**
         * Check result
         */
        $this->assertNull($allSenderOptions);
    }

    /**
     * @covers NewPackage::validateShipmentData
     */
    public function testValidateShipmentDataEmptyRequiredData()
    {
        /**
         * Insert data
         */
        $params = [
            'api_key'           => '<api_key>',
            'label_format'      => 'PDF',
            'service'           => 'PPTT',
            'description'       => 'Opis produktu',
            'value'             => '50',
            'weight'            => '1'
        ];

        /**
         * Execute
         */
        $this->expectException(Exception::class);
        NewPackage::validateShipmentData($params);
    }

    /**
     * @covers NewPackage::validateOrderData
     */
    public function testValidateOrderData()
    {
        /**
         * Insert data
         */
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

        /**
         * Execute
         */
        $allSenderOptions = NewPackage::validateOrderData($order);

        /**
         * Check result
         */
        $this->assertNull($allSenderOptions);
    }

    /**
     * @covers NewPackage::validateOrderData
     */
    public function testValidateOrderDataEmptyRequiredData()
    {
        /**
         * Insert data
         */
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
            'delivery_city'       => 'Bucuresti, Sector 3',
            'delivery_postalcode' => '031179',
            'delivery_country'    => 'RO',
            'delivery_email'      => 'john@doe.com',
            'delivery_phone'      => '555555555',
        ];

        /**
         * Execute
         */
        $this->expectException(Exception::class);
        NewPackage::validateOrderData($order);
    }
}