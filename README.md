# Picqer Extended Integration for Shopware
Shopware extension for Picqer

## Installation
This project can easily be installed through Composer.

```
    composer require picqer/shopware-plugin
```

## Activate Plugin
1. Log onto your Shopware Backend Admin account and navigate to Configuration > Plugin Manager > Picqer Order Pusher.
2. Install and activate the Picqer Order Pusher. 
3. Fill out the general configuration information: 
    + Connection Key: can be found in Picqer > Settings > Webshops > Shopware shop. Copy and paste this field. 
    + Subdomain: is the prefix of your domain name. If your log on to 'my-shop.picqer.com', then fill in 'my-shop'.

Orders will now be pushed to Picqer immediately. 

## Uninstall
1. Log onto your Shopware Backend Admin account and navigate to Configuration > Plugin Manager > Picqer Order Pusher.
2. Deactivate and uninstall Picqer Order Pusher. 
