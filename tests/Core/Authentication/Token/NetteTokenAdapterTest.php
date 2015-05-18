<?php

namespace Symnedi\Security\Tests\Core\Authentication\Token;

use Mockery;
use Nette\Http\UserStorage;
use Nette\Security\Identity;
use Nette\Security\User;
use PHPUnit_Framework_TestCase;
use Symnedi\Security\Core\Authentication\Token\NetteTokenAdapter;
use Symnedi\Security\Exception\NotImplementedException;


class NetteTokenAdapterTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var NetteTokenAdapter
	 */
	private $netteTokenAdapter;


	protected function setUp()
	{
		$userStorageMock = Mockery::mock(UserStorage::class, [
			'setAuthenticated' => '...'
		]);

		$identityMock = Mockery::mock(Identity::class, [
			'getData' => 'attributes'
		]);

		$userMock = Mockery::mock(User::class, [
			'getRoles' => ['user'],
			'getIdentity' => $identityMock,
			'isLoggedIn' => TRUE,
			'getStorage' => $userStorageMock,
		]);
		$this->netteTokenAdapter = new NetteTokenAdapter($userMock);
	}


	public function testSetGetUser()
	{
		$this->assertInstanceOf(User::class, $this->netteTokenAdapter->getUser());
		$this->netteTokenAdapter->setUser('...');
		$this->assertSame('...', $this->netteTokenAdapter->getUser());
	}


	public function testGetRoles()
	{
		$this->assertSame(['user'], $this->netteTokenAdapter->getRoles());
	}


	public function testGetCredentials()
	{
		$this->assertInstanceOf(Identity::class, $this->netteTokenAdapter->getCredentials());
	}


	public function testIsAuthenticated()
	{
		$this->assertTrue($this->netteTokenAdapter->isAuthenticated());
		$this->netteTokenAdapter->setAuthenticated('...');
	}


	public function testToString()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->__toString();
	}


	public function testSerialize()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->serialize();
	}


	public function testUnserialize()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->unserialize('...');
	}


	public function testGetUsername()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->getUsername();
	}


	public function testEraseCredentials()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->eraseCredentials();
	}


	public function testGetAttributes()
	{
		$this->assertSame('attributes', $this->netteTokenAdapter->getAttributes());
	}


	public function testSetAttributes()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->setAttributes(['someKey' => 'someValue']);
	}


	public function testHasAttribute()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->hasAttribute('someKey');
	}


	public function testGetAttribute()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->getAttribute('someKey');
	}


	public function testSetAttribute()
	{
		$this->setExpectedException(NotImplementedException::class);
		$this->netteTokenAdapter->setAttribute('someKey', 'someValue');
	}

}