<?php
namespace Sellastica\App\Presentation;

use Sellastica\Twig\Model\ProxyEntity;

/**
 * {@inheritdoc}
 * @property \Sellastica\App\Entity\App $parent
 */
class AppProxy extends ProxyEntity
{
	/** @var array */
	private $customFields;

	/**
	 * @return array
	 */
	public function getCustom_fields(): array
	{
		if (!isset($this->customFields)) {
			$this->customFields = [];
			foreach ($this->parent->getCustomFields() as $customField) {
				$this->customFields[$customField->getSlug()] = $customField->toProxy();
			}
		}

		return $this->customFields;
	}

	/**
	 * @return string
	 */
	public function getShortName()
	{
		return 'app';
	}

	/**
	 * @return array
	 */
	public function getAllowedProperties()
	{
		return [
			'custom_fields',
		];
	}
}