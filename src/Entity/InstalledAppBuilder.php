<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\IBuilder;
use Sellastica\Entity\TBuilder;
use Sellastica\Utils\Camelized;

/**
 * @see InstalledApp
 */
class InstalledAppBuilder implements IBuilder
{
	use TBuilder;

	/** @var Camelized */
	private $slug;
	/** @var \DateTime|null */
	private $trialFrom;
	/** @var \DateTime|null */
	private $trialTill;

	/**
	 * @param Camelized $slug
	 */
	public function __construct(Camelized $slug)
	{
		$this->slug = $slug;
	}

	/**
	 * @return Camelized
	 */
	public function getSlug(): Camelized
	{
		return $this->slug;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getTrialFrom()
	{
		return $this->trialFrom;
	}

	/**
	 * @param \DateTime|null $trialFrom
	 * @return $this
	 */
	public function trialFrom(\DateTime $trialFrom = null)
	{
		$this->trialFrom = $trialFrom;
		return $this;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getTrialTill()
	{
		return $this->trialTill;
	}

	/**
	 * @param \DateTime|null $trialTill
	 * @return $this
	 */
	public function trialTill(\DateTime $trialTill = null)
	{
		$this->trialTill = $trialTill;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function generateId(): bool
	{
		return !InstalledApp::isIdGeneratedByStorage();
	}

	/**
	 * @return InstalledApp
	 */
	public function build(): InstalledApp
	{
		return new InstalledApp($this);
	}

	/**
	 * @param Camelized $slug
	 * @return self
	 */
	public static function create(Camelized $slug): self
	{
		return new self($slug);
	}
}