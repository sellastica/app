<?php
namespace Sellastica\App\Service;

class ApplicationService
{
	const
		I_DOKLAD = 'i_doklad',
		LOW_STOCK_ALERT = 'low_stock_alert',
		MONEY_S3 = 'money_s3',
		MULTISTORE = 'multistore',
		SHOPTET = 'shoptet',
		SUPPLIERS = 'suppliers';

	/** @var \Sellastica\Entity\EntityManager */
	private $em;
	/** @var \Sellastica\Crm\Entity\Tariff\Service\TariffService */
	private $tariffService;
	/** @var \Sellastica\Crm\Entity\TariffHistory\Service\TariffHistoryService */
	private $historyService;
	/** @var \Sellastica\App\Entity\App[] */
	private $apps = [];


	/**
	 * @param \Sellastica\Entity\EntityManager $em
	 * @param \Sellastica\Crm\Entity\Tariff\Service\TariffService $tariffService
	 * @param \Sellastica\Crm\Entity\TariffHistory\Service\TariffHistoryService $historyService
	 */
	public function __construct(
		\Sellastica\Entity\EntityManager $em,
		\Sellastica\Crm\Entity\Tariff\Service\TariffService $tariffService,
		\Sellastica\Crm\Entity\TariffHistory\Service\TariffHistoryService $historyService
	)
	{
		$this->em = $em;
		$this->tariffService = $tariffService;
		$this->historyService = $historyService;
	}

	/**
	 * @param int $id
	 * @return null|\Sellastica\App\Entity\App
	 */
	public function find(int $id): ?\Sellastica\App\Entity\App
	{
		return $this->em->getRepository(\Sellastica\App\Entity\App::class)->find($id);
	}

	/**
	 * @param \Sellastica\Entity\Configuration|null $configuration
	 * @return \Sellastica\App\Entity\AppCollection
	 */
	public function findAllVisible(
		\Sellastica\Entity\Configuration $configuration = null
	): \Sellastica\App\Entity\AppCollection
	{
		return $this->em->getRepository(\Sellastica\App\Entity\App::class)
			->findBy(['visible' => true], $configuration);
	}

	/**
	 * @param string $slug
	 * @return \Sellastica\App\Entity\App|null
	 */
	public function getApplication(string $slug): ?\Sellastica\App\Entity\App
	{
		if (!isset($this->apps[$slug])) {
			if ($app = $this->em->getRepository(\Sellastica\App\Entity\App::class)->findOneBy([
				'slug' => $slug,
				'integroid' => true,
			])) {
				$this->apps[$slug] = $app;
			}
		}

		return $this->apps[$slug] ?? null;
	}

	/**
	 * @param string $slug
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return \Sellastica\App\Entity\App|null
	 */
	public function getInstalledApplication(
		string $slug,
		\Sellastica\Project\Entity\Project $project
	): ?\Sellastica\App\Entity\App
	{
		/** @var \Sellastica\App\Entity\App $application */
		$application = $this->em->getRepository(\Sellastica\App\Entity\App::class)->findOneBy(['slug' => $slug]);
		return ($application && $this->isInstalled($application, $project)) ? $application : null;
	}

	/**
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return \Sellastica\App\Entity\AppCollection
	 */
	public function findInstalledApplications(
		\Sellastica\Project\Entity\Project $project
	): \Sellastica\App\Entity\AppCollection
	{
		return $this->em->getRepository(\Sellastica\App\Entity\App::class)->findAllInstalled($project->getId());
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function isInstalled(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		return (bool)$this->em->getRepository(\Sellastica\App\Entity\App::class)->isInstalled(
			$project->getId(), $app->getId()
		);
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function canInstallTrial(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		return !$this->isInstalled($app, $project)
			|| !$this->historyService->getCurrentHistory($app, $project);
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function isTrial(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		if (!$this->isInstalled($app, $project)) {
			return false;
		}

		$currentHistory = $this->historyService->getCurrentHistory($app, $project);
		return $currentHistory && $currentHistory->isTrial();
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function isTrialExpired(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		if (!$this->isInstalled($app, $project)) {
			return false;
		}

		$lastHistory = $this->historyService->getLastHistory($app, $project);
		return $lastHistory && $lastHistory->isTrialExpired();
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function canRun(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		if (!$this->isInstalled($app, $project)
			|| !$this->hasTariff($app, $project)) {
			return false;
		}

		return true;
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function hasTariff(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		return (bool)$this->historyService->getCurrentHistory($app, $project);
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return int
	 */
	public function getTrialDaysLeft(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): int
	{
		if ($currentHistory = $this->historyService->getCurrentHistory($app, $project)) {
			return $currentHistory->getTrialDaysLeft();
		}

		return 0;
	}

	/**
	 * @param \Sellastica\App\Entity\App $app
	 * @param \Sellastica\Project\Entity\Project $project
	 * @return bool
	 */
	public function isProduction(
		\Sellastica\App\Entity\App $app,
		\Sellastica\Project\Entity\Project $project
	): bool
	{
		$currentHistory = $this->historyService->getCurrentHistory($app, $project);
		return $currentHistory && $currentHistory->isProduction();
	}
}