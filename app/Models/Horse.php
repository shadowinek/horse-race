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
}
