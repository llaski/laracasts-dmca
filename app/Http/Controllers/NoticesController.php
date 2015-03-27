<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareNoticeRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Guard;
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

	/**
	 * Ask user to confirm DMCA to be delivered
	 *
	 * @param  PrepareNoticeRequest $request
	 * @param  Guard                $auth
	 * @return \Response
	 */
	public function confirm(PrepareNoticeRequest $request, Guard $auth)
	{
		$template = $this->compileDmcaTemplate($data = $request->all(), $auth);

		session()->flash('dmca', $data);

		return view('notices.confirm', compact('template'));
	}

	/**
	 * Compile the DMCA Template from the form data
	 *
	 * @param  array $data
	 * @param  Guard  $auth
	 * @return mixed
	 */
	private function compileDmcaTemplate($data, Guard $auth)
	{
		$data = $data + [
			'name' => $auth->user()->name,
			'email' => $auth->user()->email
		];

		return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
	}

	public function store()
	{
		$data = session()->get('dmca');

		return $data;
	}

}
