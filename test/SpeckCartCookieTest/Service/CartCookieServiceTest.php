<?php

namespace SpeckCatalogTest\Service;

use Zend\Http\PhpEnvironment\Request;
use SpeckCartCookie\Mapper\CartVerifierMapperInterface;


class CartCookieServiceTest extends \PHPUnit_Framework_TestCase
{
	public function testVerifierCreation()
	{
		$service = $this->getService();
		$verifier = $service->createVerifier();

		$this->assertEquals(32, strlen($verifier));

		$verifier1 = $service->createVerifier();
		$this->assertNotEquals($verifier, $verifier1, 'Failed to assure that verifiers are different');
	}

	public function testVerifierLength()
	{
		$service = $this->getService();
		$verifier = $service->createVerifier(10);
		$this->assertEquals(10, strlen($verifier));
	}

	public function testSetGetCookieParameters()
	{
		$service = $this->getService();
		$service->setCookieConfig($this->getCookieParameters());

		$this->assertInternalType('array', $service->getCookieConfig());
		$this->assertArrayHasKey('cart_cookie_expiry', $service->getCookieConfig());
	}

	public function testSetGetCookieExpiry()
	{
		$service = $this->getService();
		$service->setCookieExpiry(60);
		$this->assertEquals(60, $service->getCookieConfig()['cart_cookie_expiry']);
		$this->assertEquals(60, $service->getCookieExpiry());
	}

	public function testSetGetCookieDomain()
	{
		$service = $this->getService();
		$service->setCookieDomain('test.domain');

		$this->assertEquals('test.domain', $service->getCookieConfig()['cart_cookie_domain']);
		$this->assertEquals('test.domain', $service->getCookieDomain());
	}

	public function testSetGetCookieSecure()
	{
		$service = $this->getService();
		$service->setCookieSecure(true);

		$this->assertTrue($service->getCookieConfig()['cart_cookie_secure']);
		$this->assertTrue($service->getCookieSecure());
	}

	public function testSetGetCookieUrl()
	{
		$service = $this->getService();
		$service->setCookieUrl('/some/page');

		$this->assertEquals('/some/page', $service->getCookieConfig()['cart_cookie_url']);
		$this->assertEquals('/some/page', $service->getCookieUrl());
	}

	public function getCookieParameters()
	{
		return array(
				'cart_cookie_expiry' => 10080,
				'cart_cookie_domain' => null,
				'cart_cookie_secure' => false,
				'cart_cookie_url'    => '/',
		);
	}

	public function getService()
	{
		return new \SpeckCartCookie\Service\CartCookie();
	}
}
