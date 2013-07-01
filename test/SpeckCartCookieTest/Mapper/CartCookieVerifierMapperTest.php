<?php

namespace SpeckCartCookieTest\Mapper;

use SpeckCartCookieTest\Mapper\TestAsset\AbstractTestCase;

class CartCookieVerifierMapperTest extends AbstractTestCase
{
	public function testFindByVerifierReturnsId()
	{
		// not yet implemented
	}


    public function getMapper()
    {
        $mapper =  $this->getServiceManager()->get('speckcartcookie_test_mapper');
        return $mapper;
    }

    public function getServiceManager()
    {
        return \SpeckCartCookieTest\Bootstrap::getServiceManager();
    }
}
