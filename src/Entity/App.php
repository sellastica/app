<?php
namespace Sellastica\App\Entity;

use Nette\Http\IRequest;
use Sellastica\App\Presentation\AppProxy;
use Sellastica\CustomField\Entity\GlobalCustomFieldBuilder;
use Sellastica\CustomField\Entity\GlobalCustomFieldCollection;
use Sellastica\CustomField\Entity\GlobalCustomFieldFactory;
use Sellastica\CustomField\Model\CustomFieldType;
use Sellastica\Entity\Entity\AbstractEntity;
use Sellastica\Entity\Entity\TAbstractEntity;
use Sellastica\Entity\Event\EntityCreated;
use Sellastica\Entity\Event\EntityRemoved;
use Sellastica\Twig\Model\IProxable;
use Sellastica\Twig\Model\ProxyConverter;
use Sellastica\Utils\Camelized;
use Sellastica\Utils\Images;
use Sellastica\Utils\Strings;

/**
 * @generate-builder
 * @see AppBuilder
 *
 * @property AppRelations $relationService
 */
class App extends AbstractEntity implements IProxable
{
	use TAbstractEntity;

	/** @var string @required */
	private $title;
	/** @var Camelized @required */
	private $slug;
	/** @var string|null @optional */
	private $perex;
	/** @var bool @optional */
	private $internal = false;
	/** @var bool @optional */
	private $visible = false;

	/** @var \Sellastica\App\Entity\InstalledApp|null */
	private $installedApp;

	/** @var GlobalCustomFieldCollection|\Sellastica\CustomField\Entity\GlobalCustomField[] */
	private $customFields;
	/** @var GlobalCustomFieldFactory */
	private $customFieldFactory;
	/** @var IRequest */
	private $httpRequest;


	/**
	 * @param \Sellastica\App\Entity\AppBuilder $builder
	 */
	public function __construct(\Sellastica\App\Entity\AppBuilder $builder)
	{
		$this->hydrate($builder);
	}

	/**
	 * @param GlobalCustomFieldFactory $customFieldFactory
	 * @param IRequest $httpRequest
	 */
	public function doInitialize(
		//factories
		GlobalCustomFieldFactory $customFieldFactory,
		//other
		IRequest $httpRequest
	)
	{
		//factories
		$this->customFieldFactory = $customFieldFactory;
		//other
		$this->httpRequest = $httpRequest;
	}

	/**
	 * @return bool
	 */
	public static function isIdGeneratedByStorage(): bool
	{
		return true;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getSlug(): string
	{
		return $this->slug->getValue();
	}

	/**
	 * @return string
	 */
	public function getUrlSlug(): string
	{
		return self::toUrlSlug($this->getSlug());
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return self::toAppName($this->getSlug());
	}

	/**
	 * @return string|null
	 */
	public function getPerex()
	{
		return $this->perex;
	}

	/**
	 * @return bool
	 */
	public function isInternal(): bool
	{
		return $this->internal;
	}

	/**
	 * @return bool
	 */
	public function isVisible(): bool
	{
		return $this->visible;
	}

	/**
	 * @return \Sellastica\App\Entity\InstalledApp|null
	 */
	public function getInstalledApp(): ?\Sellastica\App\Entity\InstalledApp
	{
		if (!isset($this->installedApp)) {
			$this->installedApp = $this->relationService->getInstalledApp();
		}

		return $this->installedApp;
	}

	/**
	 * @return bool
	 */
	public function isInstalled(): bool
	{
		return (bool)$this->getInstalledApp();
	}

	public function uninstall()
	{
		if ($this->isInstalled()) {
			$this->eventPublisher->publish(new EntityRemoved($this->getInstalledApp()));
			$this->installedApp = null;
		}
	}

	/**
	 * @return GlobalCustomFieldCollection|\Sellastica\CustomField\Entity\GlobalCustomField[]
	 */
	public function getCustomFields(): GlobalCustomFieldCollection
	{
		if (!isset($this->customFields)) {
			$this->customFields = $this->relationService->getCustomFields();
		}

		return $this->customFields;
	}

	/**
	 * @param string $key
	 * @return \Sellastica\CustomField\Entity\GlobalCustomField|null
	 */
	public function getCustomField(string $key): ?\Sellastica\CustomField\Entity\GlobalCustomField
	{
		return $this->getCustomFields()->getBy('slug', $key);
	}

	/**
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getCustomFieldValue(string $key, $default = null)
	{
		$customField = $this->getCustomFields()->getBy('slug', $key);
		return $customField && $customField->getResolvedValue() !== null
			? $customField->getResolvedValue()
			: $default;
	}

	/**
	 * @param string $key
	 * @param null|string $value
	 * @param \Sellastica\CustomField\Model\CustomFieldType|null $type
	 */
	public function setCustomField(string $key, ?string $value, CustomFieldType $type = null): void
	{
		if ($customField = $this->getCustomField($key)) {
			$customField->setValue($value);
			if ($type) {
				$customField->setType($type);
			}
		} else {
			$customField = GlobalCustomFieldBuilder::create($this->slug, $key, $type ?? \Sellastica\CustomField\Model\CustomFieldType::string())
				->value($value)
				->build();
			$this->eventPublisher->publish(new EntityCreated($customField));
			$this->customFields = $this->getCustomFields()->add($customField);
		}
	}

	/**
	 * @return null|string
	 */
	public function getImageFile(): ?string
	{
		$file = sprintf('%s/%s/app.png', APPLICATIONS_DIR, $this->getName());
		return is_file($file)
			? Images::toBase64($file)
			: null;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return array_merge($this->parentToArray(), [
			'title' => $this->title,
			'slug' => $this->getSlug(),
			'internal' => $this->internal,
			'visible' => $this->visible,
		]);
	}

	/**
	 * @return \Sellastica\App\Presentation\AppProxy
	 */
	public function toProxy(): AppProxy
	{
		return ProxyConverter::convert($this, AppProxy::class);
	}

	/**
	 * Returns app name in camelized form, e.g. MyAppName
	 * @param string $slug
	 * @return string
	 */
	public static function toAppName(string $slug): string
	{
		$slug = str_replace('-', '_', $slug);
		return Strings::toCamelCase($slug, '_', true);
	}

	/**
	 * Returns app slug in URL form, e,g, my-app-name
	 * @param string $slug
	 * @return string
	 */
	public static function toUrlSlug(string $slug): string
	{
		$slug = Strings::fromCamelCase($slug, '-');
		return Strings::slugify($slug, '-');
	}

	/**
	 * Returns app slug in basic form, e,g, my_app_name
	 * @param string $slug
	 * @return string
	 */
	public static function toAppSlug(string $slug): string
	{
		return Strings::slugify($slug, '_');
	}
}