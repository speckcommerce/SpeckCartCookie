<?php

$return['cart_cookie'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `cart_cookie`(
    `cart_verifier`   VARCHAR(32) PRIMARY KEY,
    'cart_id'         INTEGER(11)
);
sqlite;

return $return;
