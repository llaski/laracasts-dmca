<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Authenticated User
	 *
	 * @var \Auth\User|null
	 */
	protected $user;

	/**
	 * User signed in?
	 *
	 * @var \Auth\User|null
	 */
	protected $signedIn;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->user = $this->signedIn = Auth::user();
	}

}
