<?php

namespace SpeckCartCookie\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class CartCookieVerifierMapper extends AbstractDbMapper implements CartVerifierMapperInterface
{
	protected $tableName = 'cart_cookie';

	public function findByVerifier($verifier)
	{
		$this->setEntityPrototype(new \stdClass());
		$select = $this->getSelect($this->tableName)->columns(array('cart_id'));
		$select->where(array('cart_verifier' => $verifier));

		$result = $this->select($select)->getDataSource();

		$cartId = null;

		foreach($result as $row)
		{
			$cartId = $row['cart_id'];
		}

		return $cartId;
	}

	public function persist($verifier, $cartId)
	{
		$sqlString = "INSERT INTO $this->tableName VALUES ('".$verifier."', $cartId)";
		return $this->getDbAdapter()->query($sqlString)->execute();
	}
}
