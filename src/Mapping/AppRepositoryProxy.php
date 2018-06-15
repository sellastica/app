<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\IAppRepository;
use Sellastica\Entity\Mapping\RepositoryProxy;

/**
 * @method AppRepository getRepository()
 */
class AppRepositoryProxy extends RepositoryProxy implements IAppRepository
{
	public function findAllInstalled(
		int $projectId,
		\Sellastica\Entity\Configuration $configuration = null
	): \Sellastica\App\Entity\AppCollection
	{
		return $this->getRepository()->findAllInstalled($projectId, $configuration);
	}

	public function isInstalled(int $projectId, int $applicationId): bool
	{
		return $this->getRepository()->isInstalled($projectId, $applicationId);
	}

	public function findBySlug(string $slug)
	{
		return $this->getRepository()->findBySlug($slug);
	}
}
