<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Entity\EntityCollection;

/**
 * @property InstalledApp[] $items
 * @method InstalledAppCollection add($entity)
 * @method InstalledAppCollection remove($key)
 * @method InstalledApp|mixed getEntity(int $entityId, $default = null)
 * @method InstalledApp|mixed getBy(string $property, $value, $default = null)
 */
class InstalledAppCollection extends EntityCollection
{
}