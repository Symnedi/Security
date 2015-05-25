<?php

/**
 * This file is part of Symnedi.
 * Copyright (c) 2014 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Symnedi\Security\Contract\Http;

use Nette\Application\Application;
use Nette\Application\Request;


/**
 * Mimics @see \Symfony\Component\Security\Http\Firewall\ListenerInterface
 */
interface ListenerInterface
{

	function handle(Application $application, Request $applicationRequest);

}
