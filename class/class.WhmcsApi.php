<?php

namespace ProxmoxMigration\DB;

use ProxmoxMigration\DB\System;



class WhmcsApi
{
    private $devIdentifier;
    private $devSecret;
    private $devUrl;
    private $prodIdentifier;
    private $prodSecret;
    private $prodUrl;

    const RESPONSE_TYPE = 'responsetype';
    const JSON = 'json';
    const ENCRYPT_PASSWORD = 'EncryptPassword';
    const DECRYPT_PASSWORD = 'DecryptPassword';
    const ENCRYPT_ARGUMENT = 'encrypt';
    const DECRYPT_ARGUMENT = 'decrypt';

    public function __construct()
    {
        /**
         * Dev mode
         */
        $this->devIdentifier = getenv('DEV_WHMCS_API_IDENTIFIER');
        $this->devSecret = getenv('DEV_WHMCS_API_SECRET');
        $this->devUrl = getenv('DEV_WHMCS_API_URL');

        /**
         * Prod mode
         */
        $this->prodIdentifier = getenv('PROD_WHMCS_API_IDENTIFIER');
        $this->prodSecret = getenv('PROD_WHMCS_API_SECRET');
        $this->prodUrl = getenv('PROD_WHMCS_API_URL');
    }

    public function getDevApiIdentifier()
    {
        return $this->devIdentifier;
    }

    public function getDevApiSecret()
    {
        return $this->devSecret;
    }

    public function getDevApiUrl()
    {
        return $this->devUrl;
    }

    public function getProdApiIdentifier()
    {
        return $this->prodIdentifier;
    }

    public function getProdApiSecret()
    {
        return $this->prodSecret;
    }

    public function getProdApiUrl()
    {
        return $this->prodUrl;
    }

    private function setDevApiRequest($action, $password)
    {
        return [
            'action' => $action,
            'username' => $this->devIdentifier,
            'password' => $this->devSecret,
            self::RESPONSE_TYPE => self::JSON,
            'password2' => $password
        ];
    }

    private function setProdApiRequest($action, $password)
    {
        return [
            'action' => $action,
            'username' => $this->prodIdentifier,
            'password' => $this->prodSecret,
            self::RESPONSE_TYPE => self::JSON,
            'password2' => $password,
        ];
    }

    public function sendApiRequest($action, $mode, $password)
    {
        $query = [];

        switch ($mode) {

            case System::DEVELOPMENT_MODE:
                $url = $this->devUrl;
                $query = $this->setDevApiRequest($action, $password);
                break;

            case System::PRODUCTION_MODE:
                $url = $this->prodUrl;
                $query = $this->setProdApiRequest($action, $password);
                break;

            default:
                break;

        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}