<?php

namespace SpeckCartCookie\Mapper;

interface CartVerifierMapperInterface
{
	public function findByVerifier($verifier);

	public function persist($verifier, $cartId);
}