<?php

namespace SpeckCartCookie\Service;

use Zend\Session\Container;
use Zend\Math\Rand;
use SpeckCartCookie\Mapper\CartVerifierMapperInterface;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Http\Header\SetCookie;
use SpeckCart\Service\CartEvent;

class CartCookie
{
    protected $cookieVerifierMapper;
    protected $request;
    protected $response;
    protected $cookieConfig;

    public function retrieveCartVerifierCookie()
    {
        if($this->getRequest() instanceof \Zend\Http\PhpEnvironment\Request) {
            $cookies = $this->getRequest()->getCookie();
            if (isset($cookies['speckcart_verifier'])) {
                $this->setSessionVariableFromVerifier($cookies['speckcart_verifier']);
            }
        }
    }

    public function setSessionVariableFromVerifier($verifier)
    {
        $cartId = $this->getCookieVerifierMapper()->findByVerifier($verifier);

        if($cartId) {
            $container = new Container('speckcart');
            $container->cartId = $cartId;
        }
    }

    public function setCartVerifierCookie(CartEvent $e)
    {
        $cart = $e->getParam('cart');

        $verifier = $this->createVerifier();
        $mapper = $this->getCookieVerifierMapper();
        $mapper->persist($verifier, $cart->getCartId());

        $cookie = new SetCookie('speckcart_verifier', $verifier, time()+($this->getCookieExpiry()*60), $this->getCookieUrl(), $this->getCookieDomain(), $this->getCookieSecure());
        $this->getResponse()->getHeaders()->addHeader($cookie);
    }

    public function removeCartVerifierCookie(CartEvent $e)
    {
        $cookie = new SetCookie('speckcart_verifier', null, time()-3600, $this->getCookieUrl());
        $this->getResponse()->getHeaders()->addHeader($cookie);
    }

    public function createVerifier($length=32, $characterSet='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
    	//TODO: Should probably handle check for duplication... chances are 2x10^52 so unlikely.
        return Rand::getString($length, $characterSet);
    }

    public function setCookieVerifierMapper(CartVerifierMapperInterface $mapper)
    {
        $this->cookieVerifierMapper = $mapper;
        return $this;
    }

    public function getCookieVerifierMapper()
    {
        return $this->cookieVerifierMapper;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setCookieConfig($config)
    {
        $this->cookieConfig = $config;
        return $this;
    }

    public function getCookieConfig()
    {
        return $this->cookieConfig;
    }

    public function setCookieExpiry($expiry)
    {
        $this->cookieConfig['cart_cookie_expiry'] = $expiry;
        return $this;
    }

    public function getCookieExpiry()
    {
        return $this->cookieConfig['cart_cookie_expiry'];
    }

    public function setCookieDomain($domain)
    {
        $this->cookieConfig['cart_cookie_domain'] = $domain;
        return $this;
    }

    public function getCookieDomain()
    {
        return $this->cookieConfig['cart_cookie_domain'];
    }

    public function setCookieUrl($url)
    {
        $this->cookieConfig['cart_cookie_url'] = $url;
        return $this;
    }

    public function getCookieUrl()
    {
        return $this->cookieConfig['cart_cookie_url'];
    }

    public function setCookieSecure($httpsOnly)
    {
        $this->cookieConfig['cart_cookie_secure'] = $httpsOnly;
        return $this;
    }

    public function getCookieSecure()
    {
        return $this->cookieConfig['cart_cookie_secure'];
    }
}
