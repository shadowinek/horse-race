<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'length',
		'current_step',
		'last_step',
	];

	/**
	 * Set relation to Horses
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function horses() {
		return $this->hasMany(Horse::class);
	}
}
