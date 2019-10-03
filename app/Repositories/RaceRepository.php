<?php

namespace App\Repositories;

use App\Models\Race;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class RaceRepository {

	/**
	 * @return Race
	 */
	public function generateRandomRace(): Race {
		$race = new Race();

		$race->name = $this->generateRaceName();
		$race->length = config('default.track_length');

		$race->save();

		return $race;
	}

	/**
	 * @return string
	 */
	private function generateRaceName(): string {
		return ucfirst(Lorem::word()) . ' ' . DateTime::year();
	}

	public function getActiveRaces() {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->orderBy('created_at', 'DESC')
			->get();
	}

	public function countActiveRaces() {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->count();
	}

	public function progressRaces() {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->increment('current_step', 1);
	}

	public function getLatestFinishedRaces($limit) {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step >= last_step')
			->orderBy('updated_at', 'DESC')
			->limit($limit)
			->get();
	}
}
