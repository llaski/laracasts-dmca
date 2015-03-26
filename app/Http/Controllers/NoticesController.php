<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareNoticeRequest;
use Illuminate\Http\Request;
use App\Provider;

class NoticesController extends Controller {

	/**
	 * Create new notices controller
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show all notices
	 *
	 * @return string
	 */
	public function index()
	{
		return 'all notices';
	}

	/**
	 * Form to create a notice
	 *
	 * @return string
	 */
	public function create()
	{
		$providers = Provider::lists('name', 'id');

		//get list of providers
		return view('notices.create', compact('providers'));
	}

	public function confirm(PrepareNoticeRequest $request)
	{
		return $request->all();
	}

}
