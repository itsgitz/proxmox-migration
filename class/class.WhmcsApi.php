<?php

namespace ProxmoxMigration\DB;

class WhmcsApi
{
    private $identifier;
    private $secret;
    private $url;

    const JSON = 'json';
    const ENCRYPT_PASSWORD = 'EncryptPassword';
    const DECRYPT_PASSWORD = 'DecryptPassword';

    public function __construct()
    {
        $this->identifier = getenv('WHMCS_API_IDENTIFIER');
        $this->secret = getenv('WHMCS_API_SECRET');
        $this->url = getenv('WHMCS_API_URL');
    }

    public function getApiIdentifier()
    {
        return $this->identifier;
    }

    public function getApiSecret()
    {
        return $this->secret;
    }

    public function getApiUrl()
    {
        return $this->url;
    }

    public function sendApiRequest($action, $password)
    {
        $query = [
            'action' => $action,
            'username' => $this->identifier,
            'password' => $this->secret,
            'responsetype' => self::JSON,
            'password2' => $password
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        print_r($response);
    }
}