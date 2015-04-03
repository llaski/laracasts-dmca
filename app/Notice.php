<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model {

	protected $guarded = ['id', 'created_at', 'deleted_at'];

	/**
	 * Notice belongs to user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Notice belongs to provider
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function provider()
	{
		return $this->belongsTo('App\Provider');
	}

	public function getProviderEmail()
	{
		return $this->provider->copyright_email;
	}

	public function getUserEmail()
	{
		return $this->user->email;
	}

}
