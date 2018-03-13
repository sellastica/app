<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\App;
use Sellastica\App\Entity\AppBuilder;
use Sellastica\App\Entity\AppCollection;
use Sellastica\Entity\Entity\EntityCollection;
use Sellastica\Entity\Entity\IEntity;
use Sellastica\Entity\IBuilder;
use Sellastica\Utils\Camelized;

/**
 * @property AppDibiMapper $mapper
 */
class AppDao extends \Sellastica\Entity\Mapping\Dao
{
	/**
	 * {@inheritdoc}
	 */
	protected function getBuilder($data, $first = null, $second = null): IBuilder
	{
		return AppBuilder::create($data->title, new Camelized($data->slug))
			->hydrate($data);
	}

	/**
	 * @param int $projectId
	 * @param \Sellastica\Entity\Configuration|null $configuration
	 * @return AppCollection
	 */
	public function findAllInstalled(
		int $projectId,
		\Sellastica\Entity\Configuration $configuration = null
	): AppCollection
	{
		return $this->getEntitiesFromCacheOrStorage($this->mapper->findAllInstalled($projectId, $configuration));
	}

	/**
	 * @param int $projectId
	 * @param int $applicationId
	 * @return bool
	 */
	public function isInstalled(int $projectId, int $applicationId): bool
	{
		return $this->mapper->isInstalled($projectId, $applicationId);
	}

	/**
	 * @return EntityCollection|AppCollection
	 */
	public function getEmptyCollection(): EntityCollection
	{
		return new AppCollection();
	}

	/**
	 * @param string $slug
	 * @return App|IEntity|null
	 */
	public function findBySlug(string $slug)
	{
		$id = $this->mapper->findBySlug($slug);
		return $this->find($id);
	}
}