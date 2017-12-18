<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Entity\EntityFactory;
use Sellastica\Entity\Entity\IEntity;

/**
 * @method InstalledApp build(\Sellastica\Entity\IBuilder $builder, bool $initialize = true, int $assignedId = null)
 */
class InstalledAppFactory extends EntityFactory
{
	/**
	 * @param IEntity|InstalledApp $entity
	 */
	public function doInitialize(IEntity $entity)
	{
	}

	/**
	 * @return string
	 */
	public function getEntityClass(): string
	{
		return InstalledApp::class;
	}
}