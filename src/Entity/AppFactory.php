<?php
namespace Sellastica\App\Entity;

use Nette\Http\IRequest;
use Sellastica\CustomField\Entity\GlobalCustomFieldFactory;
use Sellastica\Entity\Entity\EntityFactory;
use Sellastica\Entity\Entity\IEntity;
use Sellastica\Entity\EntityManager;
use Sellastica\Entity\Event\IDomainEventPublisher;
use Sellastica\Entity\IBuilder;

/**
 * @method App build(IBuilder $builder, bool $initialize = true, int $assignedId = null)
 */
class AppFactory extends EntityFactory
{
	/** @var \Sellastica\CustomField\Entity\GlobalCustomFieldFactory */
	private $customFieldFactory;
	/** @var IRequest */
	private $httpRequest;


	/**
	 * @param EntityManager $em
	 * @param IDomainEventPublisher $eventPublisher
	 * @param GlobalCustomFieldFactory $customFieldFactory
	 * @param IRequest $httpRequest
	 */
	public function __construct(
		EntityManager $em,
		IDomainEventPublisher $eventPublisher,
		\Sellastica\CustomField\Entity\GlobalCustomFieldFactory $customFieldFactory,
		IRequest $httpRequest
	)
	{
		parent::__construct($em, $eventPublisher);
		$this->customFieldFactory = $customFieldFactory;
		$this->httpRequest = $httpRequest;
	}

	/**
	 * @param IEntity|App $entity
	 */
	public function doInitialize(\Sellastica\Entity\Entity\IEntity $entity)
	{
		$entity->setRelationService(new AppRelations($entity, $this->em));
		$entity->doInitialize(
			//factories
			$this->customFieldFactory,
			//other
			$this->httpRequest
		);
	}

	/**
	 * @return string
	 */
	public function getEntityClass(): string
	{
		return App::class;
	}
}