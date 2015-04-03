<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareNoticeRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Guard;
use Mail;
use App\Provider;
use App\Notice;
use Auth;

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
	 * @param  Guard  $auth
	 * @return string
	 */
	public function index(Guard $auth)
	{
		return $auth->user()->notices;
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

	/**
	 * Store new notice
	 * @param  App\Http\Requests $request
	 * @param  Illuminate\Auth\Guard $auth
	 * @return mixed
	 */
	public function store(Request $request, Guard $auth)
	{
		try {
			$notice = $this->createNotice($request, $auth);

			Mail::queue('emails.dmca', compact('notice'), function($message) use ($notice)
			{
				$message->from($notice->getUserEmail())
								->to($notice->getProviderEmail())
								->subject('DMCA Notice');
			});

			return redirect('notices');
		}
		catch(\Exception $e)
		{
			session()->keep(['dmca']);
			throw new $e;
		}
	}

	/**
	 * Create new notice
	 * @param  App\Http\Requests $request
	 * @param  Illuminate\Auth\Guard $auth
	 * @return mixed
	 */
	private function createNotice(Request $request, Guard $auth)
	{
		$data = array_merge(session()->get('dmca'), ['template' => $request->input('template')]);

		$notice = $auth->user()->notices()->create($data);

		return $notice;
	}

}
