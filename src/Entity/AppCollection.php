<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Entity\EntityCollection;

/**
 * @property App[] $items
 * @method AppCollection add($entity)
 * @method AppCollection remove($key)
 * @method App|mixed getEntity(int $entityId, $default = null)
 * @method App|mixed getBy(string $property, $value, $default = null)
 */
class AppCollection extends EntityCollection
{
}