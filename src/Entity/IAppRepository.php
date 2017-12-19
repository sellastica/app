<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Configuration;
use Sellastica\Entity\Mapping\IRepository;

/**
 * @method \Sellastica\App\Entity\App find(int $id)
 * @method \Sellastica\App\Entity\App findOneBy(array $filterValues)
 * @method \Sellastica\App\Entity\App[] findAll(\Sellastica\Entity\Configuration $configuration = null)
 * @method \Sellastica\App\Entity\App[] findBy(array $filterValues, Configuration $configuration = null)
 * @method \Sellastica\App\Entity\App[] findByIds(array $idsArray, \Sellastica\Entity\Configuration $configuration = null)
 * @method \Sellastica\App\Entity\App findPublishable(int $id)
 * @method \Sellastica\App\Entity\App findOnePublishableBy(array $filterValues)
 * @method \Sellastica\App\Entity\App[] findAllPublishable(\Sellastica\Entity\Configuration $configuration = null)
 * @method \Sellastica\App\Entity\App[] findPublishableBy(array $filterValues, \Sellastica\Entity\Configuration $configuration = null)
 */
interface IAppRepository extends IRepository
{
	/**
	 * @param int $projectId
	 * @param int $applicationId
	 * @return bool
	 */
	function isInstalled(int $projectId, int $applicationId): bool;

	/**
	 * @param string $slug
	 * @return \Sellastica\App\Entity\App|\Sellastica\Entity\Entity\IEntity|null
	 */
	function findBySlug(string $slug);
}
