<?php

namespace PicqerOrderPusher;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use PicqerOrderPusher\Components\PicqerWebhookCall;

class PicqerOrderPusher extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'sOrder::sSaveOrder::after' => 'pushOrder',
            'sOrder::setPaymentStatus::after' => 'pushOrder',
            'sOrder::setOrderStatus::after' => 'pushOrder',
        ];
    }

    public function install(InstallContext $context)
    {
        if (file_exists(__DIR__ . '/vendor/autoload.php')) {
            require_once __DIR__ . '/vendor/autoload.php';
        }

        parent::install($context);
    }

    public function update(UpdateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);

        parent::update($context);
    }

    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }

        parent::uninstall($context);
    }

    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);

        parent::deactivate($context);
    }

    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);

        parent::activate($context);
    }

    public function pushOrder()
    {
        $config = Shopware()->Container()->get('picqer_order_pusher.config');
        $orderData = $this->getOrderPusherData();

        $picqerWebhookCall = new PicqerWebhookCall($config);
        $picqerWebhookCall->sendRequest($orderData, PicqerWebhookCall::METHOD_POST);
    }

    private function getOrderPusherData()
    {
        $this->session = Shopware()->Session();

        $orderData = [];
        $orderData['sOrderNumber'] = $this->session['sOrderVariables']['sOrderNumber'];

        return $orderData;
    }
}
