<?php


class Settings extends Eloquent {

	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'setting';

	public static function store($key, $value) {
		$setting = self::whereKey($key)->first();
		if ($setting == null) {
			$setting = new Settings;
			$setting->key = $key;
		}

		$setting->value = $value;
		$setting->save();
	}

}
