<?php

namespace SpeckCartCookieTest\Mapper\TestAsset;

use PHPUnit\Extensions\Database\TestCase;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper =  $this->getServiceManager()->get('speckcartcookie_test_mapper');
        }
        return $this->testMapper;
    }

	public function insertCartVerifier()
    {
		$mapper = $this->getTestMapper();
        $mapper->insert(array('cart_id' => 1, 'verifier' => 'thisisaverifier'), 'cart_cookie');

        return true;
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function teardown()
    {
        $this->getTestMapper()->teardown();
    }
}
