<?php
namespace Sellastica\App\Entity;

use Sellastica\CustomField\Entity\GlobalCustomField;
use Sellastica\CustomField\Entity\GlobalCustomFieldCollection;
use Sellastica\Entity\Entity\IEntity;
use Sellastica\Entity\EntityManager;
use Sellastica\Entity\Relation\IEntityRelations;

/**
 * @property \Sellastica\App\Entity\App $entity
 */
class AppRelations implements IEntityRelations
{
	/** @var IEntity */
	private $entity;
	/** @var EntityManager */
	private $em;


	/**
	 * @param IEntity $entity
	 * @param EntityManager $em
	 */
	public function __construct(
		IEntity $entity,
		EntityManager $em
	)
	{
		$this->entity = $entity;
		$this->em = $em;
	}

	/**
	 * @return GlobalCustomField[]|GlobalCustomFieldCollection
	 */
	public function getCustomFields(): GlobalCustomFieldCollection
	{
		return $this->em->getRepository(GlobalCustomField::class)->findBy(['namespace' => $this->entity->getSlug()]);
	}
}