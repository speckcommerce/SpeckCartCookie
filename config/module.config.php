<?php
return array(
    'speckcartcookie' => array(
        'cart_cookie_expiry' => 10080,   // Cookie expiry time in mins
        'cart_cookie_domain' => null,    // Set to null this defaults to the current domain
        'cart_cookie_secure' => false,   // Should the cookie be secure only?
        'cart_cookie_url'    => '/',     // Location to set in the cookie - default to root
    ),
    'service_manager' => array(
        'aliases' => array(
            'speckcartcookie_db' => 'Zend\Db\Adapter\Adapter'
        ),
    ),
);
