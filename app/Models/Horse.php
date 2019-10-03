<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horse extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'speed',
		'strength',
		'endurance',
		'time',
		'step',
	];

	/**
	 * Set relation to Race
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function race() {
		return $this->belongsTo(Race::class);
	}

	/**
	 * A horse's speed is their base speed (5 m/s) + their speed stat (in m/s)
	 *
	 * @return float
	 */
	private function calculateFullSpeed(): float {
		return ($this->attributes['speed'] / 10) + config('default.base_horse_speed');
	}

	/**
	 * A jockey slows the horse down by 5 m/s, but this effect is reduced by the horse's strength * 8 as a percentage
	 *
	 * @return float
	 */
	private function calculateSlowdownSpeed(): float {

		$reduction = (($this->attributes['strength'] / 10) * 8) / 100;
		$slowdown = 5 * (1 - $reduction);

		return $this->calculateFullSpeed() - $slowdown;
	}

	/**
	 * Endurance represents how many hundreds of meters they can run at their best speed, before the weight of the jockey slows them down
	 *
	 * @return float
	 */
	private function calculateFullSpeedDistance(): float {
		return $this->attributes['endurance'] * 10;
	}

	/**
	 * @return float
	 */
	private function calculateFullSpeedTime(): float {
		return $this->calculateFullSpeedDistance() / $this->calculateFullSpeed();
	}

	/**
	 * @param int $distance
	 *
	 * @return float
	 */
	public function calculateFinalTime(int $distance): float {
		$remainingDistance = $distance - $this->calculateFullSpeedDistance();
		$remainingTime = $remainingDistance / ($this->calculateSlowdownSpeed());

		$time = $this->calculateFullSpeedTime() + $remainingTime;

		return $time;
	}

	/**
	 * @param int $distance
	 *
	 * @return int
	 */
	public function calculateFinalStep(int $distance): int {
		return ceil($this->calculateFinalTime($distance) / config('default.progress_step_size'));
	}


	/**
	 * @param int $step
	 *
	 * @return float
	 */
	public function calculateDistance(int $step): float {
		$time = $step * config('default.progress_step_size');
		$distance = $time * $this->calculateFullSpeed();
		$fullSpeedDistance = $this->calculateFullSpeedDistance();

		if ($distance > $fullSpeedDistance) {
			$fullSpeedTime = $this->calculateFullSpeedTime();
			$reducedSpeedDistance = ($time - $fullSpeedTime) * ($this->calculateSlowdownSpeed());

			$distance = $fullSpeedDistance + $reducedSpeedDistance;
		}

		if ($distance > $this->race->length) {
			return $this->race->length;
		}

		return $distance;
	}
}
