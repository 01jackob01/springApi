<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Src\Package;

final class PackageTest extends TestCase
{
    /**
     * @var Package
     */
    private Package $package;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $apiKey = '<api_key>';
        $this->package = new Package($apiKey);
    }
    /**
     * @covers Package::createNewPackagePostData
     */
    public function testCreateNewPackagePostData()
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
         * Expected data
         */
        $expectedData = '{"Apikey":"<api_key>","Command":"OrderShipment","Shipment":{"ConsignorAddress":{"Company":"BaseLinker","Name":"Jan Kowalski","AddressLine1":"Kopernika 10","City":"Gdansk","Zip":"80208","Email":"","Phone":"666666666"},"ConsigneeAddress":{"Company":"Spring GDS","Name":"Maud Driant","AddressLine1":"Strada Foisorului, Nr. 16, Bl. F11C, Sc. 1, Ap. 10","City":"Bucuresti, Sector 3","Zip":"031179","Country":"RO","Email":"john@doe.com","Phone":"555555555"}}}';

        /**
         * Execute
         */
        $newPackageData = $this->package->createNewPackagePostData($params, $order);

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $newPackageData);
    }

    /**
     * @covers Package::createPackagePDFPostData
     */
    public function testCreatePackagePDFPostData()
    {
        /**
         * Insert data
         */
        $apiKey = 'testtest';

        /**
         * Expected data
         */
        $expectedData = '{"Apikey":"<api_key>","Command":"GetShipmentLabel","Shipment":{"LabelFormat":"PDF","TrackingNumber":"testtest"}}';

        /**
         * Execute
         */
        $newPackageData = $this->package->createPackagePDFPostData($apiKey);

        /**
         * Check result
         */
        $this->assertEquals($expectedData, $newPackageData);
    }
}