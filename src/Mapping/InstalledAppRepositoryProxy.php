<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\IInstalledAppRepository;
use Sellastica\Entity\Mapping\RepositoryProxy;

/**
 * @method InstalledAppRepository getRepository()
 */
class InstalledAppRepositoryProxy extends RepositoryProxy implements IInstalledAppRepository
{
}
