<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Configuration;
use Sellastica\Entity\Mapping\IRepository;

/**
 * @method InstalledApp find(int $id)
 * @method InstalledApp findOneBy(array $filterValues)
 * @method InstalledApp[] findAll(Configuration $configuration = null)
 * @method InstalledApp[] findBy(array $filterValues, Configuration $configuration = null)
 * @method InstalledApp[] findByIds(array $idsArray, \Sellastica\Entity\Configuration $configuration = null)
 * @method InstalledApp findPublishable(int $id)
 * @method InstalledApp findOnePublishableBy(array $filterValues)
 * @method InstalledApp[] findAllPublishable(\Sellastica\Entity\Configuration $configuration = null)
 * @method InstalledApp[] findPublishableBy(array $filterValues, \Sellastica\Entity\Configuration $configuration = null)
 */
interface IInstalledAppRepository extends IRepository
{
}
