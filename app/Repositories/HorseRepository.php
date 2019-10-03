<?php

namespace App\Repositories;

use App\Models\Horse;
use App\Models\Race;
use Faker\Provider\Color;
use Faker\Provider\en_US\Person;

class HorseRepository {

	private function generateRandomHorse(Race $race): Horse {
		$horse = new Horse();

		$horse->race_id = $race->id;
		$horse->name = $this->generateHorseName();
		$horse->speed = $this->getRandomStat();
		$horse->strength = $this->getRandomStat();
		$horse->endurance = $this->getRandomStat();
		$horse->time = round($horse->calculateFinalTime($race->length), 2) * 100;
		$horse->step = ceil(($horse->time / 100) / config('default.progress_step_size'));

		$horse->save();

		return $horse;
	}


	/**
	 * @return string
	 */
	private function generateHorseName(): string {
		return Color::colorName() . ' ' . (random_int(0,1) ? Person::firstNameFemale() : Person::firstNameMale());
	}

	/**
	 * Each stat ranges from 0.0 to 10.0
	 *
	 * @return int
	 */
	private function getRandomStat(): int {
		return mt_rand(10, 100);
	}

	/**
	 * @param int $number
	 * @param Race $race
	 */
	public function generateHorses(int $number, Race $race) {
		for($i=0;$i<$number;$i++) {
			$this->generateRandomHorse($race);
		}
	}

	public function getFastestHorse(): Horse {
		return Horse::select('horses.*')
			->leftJoin('races', 'races.id', '=', 'horses.race_id')
			->whereRaw('races.current_step >= races.last_step')
			->orderBy('horses.time', 'ASC')
			->first();
	}
}
