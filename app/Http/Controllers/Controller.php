<?php

namespace App\Http\Controllers;

use App\Repositories\HorseRepository;
use App\Repositories\RaceRepository;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	/** @var HorseRepository */
	protected $horseRepository;

	/** @var RaceRepository */
	protected $raceRepository;

	/**
	 * @param HorseRepository $horseRepository
	 */
	public function __construct(HorseRepository $horseRepository, RaceRepository $raceRepository) {
		$this->horseRepository = $horseRepository;
		$this->raceRepository = $raceRepository;
	}

	public function index() {
		$races = $this->raceRepository->getActiveRaces();
		$lastRaces = $this->raceRepository->getLatestFinishedRaces(config('default.last_results_races'));
		$fastestHorse = $this->horseRepository->getFastestHorse();

		return view('index', [
			'races' => $races,
			'lastRaces' => $lastRaces,
			'fastestHorse' => $fastestHorse,
		]);
	}

	public function showRace(int $id) {

	}

	public function showHorse(int $id) {

	}

	public function progressRaces() {
		$this->raceRepository->progressRaces();

		return redirect(route('index'));
	}

	public function generateRace() {

		if ($this->raceRepository->countActiveRaces() < config('default.max_concurrent_races')) {
			$race = $this->raceRepository->generateRandomRace();
			$this->horseRepository->generateHorses(config('default.horses_per_race'), $race);

			$race->last_step = $race->horses->max('step');

			$race->save();
		}

		return redirect(route('index'));
	}

}
