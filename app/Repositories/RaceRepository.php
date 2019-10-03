<?php

namespace App\Repositories;

use App\Models\Race;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;
use Illuminate\Database\Eloquent\Collection;

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

	/**
	 * @return Collection
	 */
	public function getActiveRaces(): Collection {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->orderBy('created_at', 'DESC')
			->get();
	}

	/**
	 * @return int
	 */
	public function countActiveRaces(): int {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->count();
	}


	/**
	 * @return bool
	 */
	public function progressRaces(): bool {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step < last_step')
			->increment('current_step', 1);
	}


	/**
	 * @param int $limit
	 *
	 * @return Collection
	 */
	public function getLatestFinishedRaces(int $limit): Collection {
		/** @noinspection PhpUndefinedMethodInspection */
		return Race::whereRaw('current_step >= last_step')
			->orderBy('updated_at', 'DESC')
			->limit($limit)
			->get();
	}
}
