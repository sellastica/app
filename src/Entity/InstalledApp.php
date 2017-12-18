<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\Entity\TAbstractEntity;
use Sellastica\Utils\Camelized;

/**
 * @generate-builder
 * @see InstalledAppBuilder
 */
class InstalledApp extends \Sellastica\Entity\Entity\AbstractEntity
{
	use TAbstractEntity;

	/** @var Camelized @required */
	private $slug;
	/** @var \DateTime|null @optional */
	private $trialFrom;
	/** @var \DateTime|null @optional */
	private $trialTill;


	/**
	 * @param \Sellastica\App\Entity\InstalledAppBuilder $builder
	 */
	public function __construct(\Sellastica\App\Entity\InstalledAppBuilder $builder)
	{
		$this->hydrate($builder);
	}

	/**
	 * @return string
	 */
	public function getSlug(): string
	{
		return $this->slug->getValue();
	}

	/**
	 * @return \DateTime|null
	 */
	public function getTrialFrom(): ?\DateTime
	{
		return $this->trialFrom;
	}

	/**
	 * @param \DateTime|null $trialFrom
	 */
	public function setTrialFrom(?\DateTime $trialFrom)
	{
		$this->trialFrom = $trialFrom;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getTrialTill(): ?\DateTime
	{
		return $this->trialTill;
	}

	/**
	 * @param \DateTime|null $trialTill
	 */
	public function setTrialTill(?\DateTime $trialTill)
	{
		$this->trialTill = $trialTill;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return array_merge($this->parentToArray(), [
			'slug' => $this->getSlug(),
			'trialFrom' => $this->trialFrom,
			'trialTill' => $this->trialTill,
		]);
	}
}