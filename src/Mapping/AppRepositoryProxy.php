<?php
namespace Sellastica\App\Mapping;

use Sellastica\App\Entity\App;
use Sellastica\App\Entity\IAppRepository;
use Sellastica\Entity\Mapping\RepositoryProxy;

/**
 * @method AppRepository getRepository()
 */
class AppRepositoryProxy extends RepositoryProxy implements IAppRepository
{
	/**
	 * @param string $slug
	 * @return App|\Sellastica\Entity\Entity\IEntity|null
	 */
	public function findBySlug(string $slug)
	{
		return $this->getRepository()->findBySlug($slug);
	}
}
