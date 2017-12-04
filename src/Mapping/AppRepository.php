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
	 * @param string $slug
	 * @return App|IEntity|null
	 */
	public function findBySlug(string $slug)
	{
		$app = $this->dao->findBySlug($slug);
		return $this->initialize($app);
	}

}
