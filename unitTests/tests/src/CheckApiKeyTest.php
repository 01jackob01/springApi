<?php

use PHPUnit\Framework\TestCase;
use Src\CheckApiKey;

class CheckApiKeyTest extends TestCase
{
    /**
     * @covers CheckApiKey::checkApiKeyValue
     */
    public function testCheckApiKeyValue()
    {
        /**
         * Insert data
         */
        $apiKey = '<api_key>';

        /**
         * Execute
         */
        $validateApiKey = CheckApiKey::checkApiKeyValue($apiKey);
        $this->assertNull($validateApiKey);
    }

    /**
     * @covers CheckApiKey::checkApiKeyValue
     */
    public function testCheckApiKeyValueEmptyApiKey()
    {
        /**
         * Insert data
         */
        $apiKey = '';

        /**
         * Execute
         */
        $this->expectException(Exception::class);
        CheckApiKey::checkApiKeyValue($apiKey);
    }

    /**
     * @covers CheckApiKey::checkApiKeyValue
     */
    public function testCheckApiKeyValueWrongApiKey()
    {
        /**
         * Insert data
         */
        $apiKey = 'testtest';

        /**
         * Execute
         */
        $this->expectException(Exception::class);
        CheckApiKey::checkApiKeyValue($apiKey);
    }
}