<?php

/**
 * This file is part of Symnedi.
 * Copyright (c) 2014 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Symnedi\Security\DI;

use Nette\DI\CompilerExtension;
use Symnedi\Security\Contract\Core\Authorization\AccessDecisionManagerFactoryInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symnedi\Security\Contract\Http\FirewallHandlerInterface;
use Symnedi\Security\Contract\Http\FirewallMapFactoryInterface;
use Symnedi\Security\Contract\HttpFoundation\RequestMatcherInterface;


class SecurityExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$containerBuilder = $this->getContainerBuilder();
		$services = $this->loadFromFile(__DIR__ . '/services.neon');
		$this->compiler->parseServices($containerBuilder, $services);
	}


	public function beforeCompile()
	{
		$containerBuilder = $this->getContainerBuilder();
		$containerBuilder->prepareClassList();

		$this->loadAccessDecisionManagerFactoryWithVoters();

		if ($containerBuilder->findByType(FirewallHandlerInterface::class)) {
			$this->loadFirewallMap();
		}
	}


	private function loadAccessDecisionManagerFactoryWithVoters()
	{
		$this->loadMediator(AccessDecisionManagerFactoryInterface::class, VoterInterface::class, 'addVoter');
	}


	private function loadFirewallMap()
	{
		$this->loadMediator(FirewallMapFactoryInterface::class, FirewallHandlerInterface::class, 'addFirewallHandler');
		$this->loadMediator(FirewallMapFactoryInterface::class, RequestMatcherInterface::class, 'addRequestMatcher');
	}


	/**
	 * @param string $mediatorClass
	 * @param string $colleagueClass
	 * @param string $adderMethod
	 */
	private function loadMediator($mediatorClass, $colleagueClass, $adderMethod)
	{
		$containerBuilder = $this->getContainerBuilder();

		$mediatorDefinition = $containerBuilder->getDefinition($containerBuilder->getByType($mediatorClass));
		foreach ($containerBuilder->findByType($colleagueClass) as $colleagueDefinition) {
			$mediatorDefinition->addSetup($adderMethod, ['@' . $colleagueDefinition->getClass()]);
		}
	}

}
