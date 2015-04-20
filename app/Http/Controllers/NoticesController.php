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
		parent::__construct();

		$this->middleware('auth');
	}

	/**
	 * Show all notices
	 *
	 * @return string
	 */
	public function index()
	{
		$notices = $this->user->notices()->latest()->get();

		return view('notices.index', compact('notices'));
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
	public function confirm(PrepareNoticeRequest $request)
	{
		$template = $this->compileDmcaTemplate($data = $request->all());

		session()->flash('dmca', $data);

		return view('notices.confirm', compact('template'));
	}

	/**
	 * Compile the DMCA Template from the form data
	 *
	 * @param  array $data
	 * @return mixed
	 */
	private function compileDmcaTemplate($data)
	{
		$data = $data + [
			'name' => $this->user->name,
			'email' => $this->user->email
		];

		return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
	}

	/**
	 * Store new notice
	 * @param  App\Http\Requests $request
	 * @param  Illuminate\Auth\Guard $auth
	 * @return mixed
	 */
	public function store(Request $request)
	{
		try {
			$notice = $this->createNotice($request);

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
	 * @return mixed
	 */
	private function createNotice(Request $request)
	{
		$data = array_merge(session()->get('dmca'), ['template' => $request->input('template')]);

		$notice = $this->user->notices()->create($data);

		return $notice;
	}

}
