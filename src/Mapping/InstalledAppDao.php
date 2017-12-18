<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\InstalledAppBuilder;
use Sellastica\App\Entity\InstalledAppCollection;
use Sellastica\Entity\Entity\EntityCollection;
use Sellastica\Entity\IBuilder;
use Sellastica\Entity\Mapping\Dao;
use Sellastica\Utils\Camelized;

/**
 * @property InstalledAppDibiMapper $mapper
 */
class InstalledAppDao extends Dao
{
	/**
	 * {@inheritdoc}
	 */
	protected function getBuilder($data, $first = null, $second = null): IBuilder
	{
		return InstalledAppBuilder::create(new Camelized($data->slug))
			->hydrate($data);
	}

	/**
	 * @return EntityCollection|\Sellastica\App\Entity\InstalledAppCollection
	 */
	protected function getEmptyCollection(): EntityCollection
	{
		return new InstalledAppCollection();
	}
}