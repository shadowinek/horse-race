<?php

return [
	// Each race is run by 8 randomly generated horses, over 1500m
	'horses_per_race' => 8,
	'track_length' => 1500,

	// A horse's speed is their base speed (5 m/s) + their speed stat (in m/s)
	'base_horse_speed' => 5,

	// Up to 3 races are allowed at the same time
	'max_concurrent_races' => 3,

	// The last 5 race results (top 3 positions and times to complete 1500m)
	'last_results_races' => 5,
	'last_results_horses' => 3,

	// A jockey slows the horse down by 5 m/s, but this effect is reduced by the horse's strength * 8 as a percentage
	'base_slowdown' => 5,
	'slowdown_modifier' => 8,

	// A button "progress" which advances all races by 10 "seconds" until all horses in the race have completed 1500m
	'progress_step_size' => 10,
];
