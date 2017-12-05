<?php
namespace Sellastica\App\Bridge\DI;

use Nette;

class AppExtension extends Nette\DI\CompilerExtension
{
	public function loadConfiguration()
	{
		$this->compiler->loadDefinitions(
			$this->getContainerBuilder(),
			$this->loadFromFile(__DIR__ . '/config.neon')['services'],
			$this->name
		);
	}
}
