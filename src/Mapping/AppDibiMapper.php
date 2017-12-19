<?php
namespace Sellastica\App\Mapping;

use Dibi;
use Sellastica\Entity\Configuration;

class AppDibiMapper extends \Sellastica\Entity\Mapping\DibiMapper
{
	/**
	 * @return bool
	 */
	protected function isInCrmDatabase(): bool
	{
		return true;
	}

	/**
	 * @param int $projectId
	 * @param int $applicationId
	 * @return bool
	 */
	public function isInstalled(int $projectId, int $applicationId): bool
	{
		return (bool)$this->database->select(1)
			->from('%n.app_project_rel', $this->environment->getCrmDatabaseName())
			->where('projectId = %i', $projectId)
			->where('applicationId = %i', $applicationId)
			->fetchSingle();
	}

	/**
	 * @param Configuration $configuration
	 * @return Dibi\Fluent
	 */
	protected function getPublishableResource(Configuration $configuration = NULL)
	{
		return parent::getResource($configuration)
			->where('installed = 1')
			->where('visible = 1');
	}

	/**
	 * @param string $slug
	 * @return int|null
	 */
	public function findBySlug(string $slug)
	{
		return $this->getResourceWithIds()
			->where('slug = %s', $slug)
			->fetchSingle();
	}
}