<?php

namespace PicqerOrderPusher\Components;

class PicqerWebhookCall
{
    protected $config;

    const METHOD_POST = 'POST';

    protected $host = 'picqer.com/';
    protected $endpoint = 'webshops/shopware/orderPush/';
    protected $protocol = 'https';

    public function __construct(
        PicqerOrderPusher\Components\Config $config
    )
    {
        $this->config = $config;
    }

    public function sendRequest($orderData, $method)
    {
        $curlSession = curl_init();

        curl_setopt($curlSession, CURLOPT_URL, $this->getUrl());
        curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));

        if (in_array($method, array(self::METHOD_POST))) {
            $data = $this->prepareData($orderData);

            curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, $data);
        }

        curl_exec($curlSession);
        curl_close($curlSession);

        return;
    }

    protected function getUrl()
    {
        return $this->protocol . '://' . $this->config->subdomain() . '.' . $this->host . $this->endpoint . $this->config->connectionKey();
    }

    protected function prepareData($orderData)
    {
        return json_encode($orderData);
    }
}