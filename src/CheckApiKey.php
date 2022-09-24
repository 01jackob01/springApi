<?php

class CheckApiKey
{
    const API_KEY = '<api_key>';

    /**
     * @throws Exception
     */
    public static function checkApiKeyValue(string $apiKey): void
    {
        if (empty($apiKey)) {
            throw new Exception("Empty Api Key");
        }
        if ($apiKey != self::API_KEY) {
            throw new Exception("Wrong Api Key");
        }
    }
}