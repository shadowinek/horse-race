<?php

namespace App\Repositories;

use App\Models\Horse;
use Faker\Provider\Color;
use Faker\Provider\Person;

class HorseRepository {

	public function generateRandomHorse(int $raceLength): ?Horse {

		$parameters = [
			'name' => $this->generateHorseName(),
			'speed' => $this->getRandomStat(),
			'strength' => $this->getRandomStat(),
			'endurance' => $this->getRandomStat(),
		];
	}

	private function generateHorseName(): string {
		return Color::colorName() . ' ' . random_int(0, 1) ? Person::firstNameFemale() : Person::firstNameMale();
	}

	// Each stat ranges from 0.0 to 10.0
	private function getRandomStat(): int {
		return mt_rand(10, 100);
	}
}
