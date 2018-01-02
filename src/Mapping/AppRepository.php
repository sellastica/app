<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\App;
use Sellastica\App\Entity\IAppRepository;
use Sellastica\Entity\Entity\IEntity;
use Sellastica\Entity\Mapping\Repository;

/**
 * @property AppDao $dao
 */
class AppRepository extends Repository implements IAppRepository
{
	/**
	 * @param int $projectId
	 * @param \Sellastica\Entity\Configuration|null $configuration
	 * @return \Sellastica\App\Entity\AppCollection
	 */
	public function findAllInstalled(
		int $projectId,
		\Sellastica\Entity\Configuration $configuration = null
	): \Sellastica\App\Entity\AppCollection
	{
		return $this->initialize($this->dao->findAllInstalled($projectId, $configuration));
	}

	/**
	 * @param int $projectId
	 * @param int $applicationId
	 * @return bool
	 */
	public function isInstalled(int $projectId, int $applicationId): bool
	{
		return $this->dao->isInstalled($projectId, $applicationId);
	}

	/**
	 * @param string $slug
	 * @return App|IEntity|null
	 */
	public function findBySlug(string $slug)
	{
		$app = $this->dao->findBySlug($slug);
		return $this->initialize($app);
	}

}
