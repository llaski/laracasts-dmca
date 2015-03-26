<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

	/**
	 * No Timestamps for provider
	 *
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Fillable fields
	 *
	 * @var array
	 */
	public $fillable = ['name', 'copyright_email'];

}
