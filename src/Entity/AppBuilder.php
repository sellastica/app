<?php
namespace Sellastica\App\Entity;

use Sellastica\Entity\IBuilder;
use Sellastica\Entity\TBuilder;
use Sellastica\Utils\Camelized;

/**
 * @see App
 */
class AppBuilder implements IBuilder
{
	use TBuilder;

	/** @var string */
	private $title;
	/** @var Camelized */
	private $slug;
	/** @var string|null */
	private $perex;
	/** @var bool */
	private $internal = false;
	/** @var bool */
	private $visible = false;
	/** @var int */
	private $version;

	/**
	 * @param string $title
	 * @param Camelized $slug
	 */
	public function __construct(
		string $title,
		Camelized $slug
	)
	{
		$this->title = $title;
		$this->slug = $slug;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @return Camelized
	 */
	public function getSlug(): Camelized
	{
		return $this->slug;
	}

	/**
	 * @return string|null
	 */
	public function getPerex()
	{
		return $this->perex;
	}

	/**
	 * @param string|null $perex
	 * @return $this
	 */
	public function perex(string $perex = null)
	{
		$this->perex = $perex;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getInternal(): bool
	{
		return $this->internal;
	}

	/**
	 * @param bool $internal
	 * @return $this
	 */
	public function internal(bool $internal)
	{
		$this->internal = $internal;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getVisible(): bool
	{
		return $this->visible;
	}

	/**
	 * @param bool $visible
	 * @return $this
	 */
	public function visible(bool $visible)
	{
		$this->visible = $visible;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getVersion(): int
	{
		return $this->version;
	}

	/**
	 * @param int $version
	 * @return $this
	 */
	public function version(int $version)
	{
		$this->version = $version;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function generateId(): bool
	{
		return !App::isIdGeneratedByStorage();
	}

	/**
	 * @return App
	 */
	public function build(): App
	{
		return new App($this);
	}

	/**
	 * @param string $title
	 * @param Camelized $slug
	 * @return self
	 */
	public static function create(
		string $title,
		Camelized $slug
	): self
	{
		return new self($title, $slug);
	}
}