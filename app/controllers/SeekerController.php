<?php

class SeekerController extends BaseController
{
	public function login()
	{
		/*if (Auth::check())
		{
			return Redirect::route('dashboard');
		}*/

		return View::make('seeker.login');
	}


	
	public function auth()
	{
		/*if (Auth::check())
		{
			return Redirect::route('dashboard');
		}*/

		$rules = [
			'mobile'   => 'required',
			'password' => 'required',
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
			Session::flash('login-error', true);
			return Redirect::back()->withErrors($validator);//['redirect' => Input::get('redirect')]
		}

		$user = User::where('mobile', '=', Input::get('mobile'))->first();

		if (!$user or !Auth::attempt(['mobile' => Input::get('mobile'), 'password' => Input::get('password')]))
		{
			Input::flash();
			Session::flash('login-error', true);
			return Redirect::back()->withErrors($validator);
		}

		return Redirect::intended(Input::get('redirect', route('dashboard')));
	}



	public function logout()
	{
		if (Auth::check())
		{
			Auth::logout();
		}

		return Redirect::route('home');
	}



	public function forget()
	{
		if (Request::isMethod('post'))
		{
			$rules = [
				'mobile'       => ['required', 'exists:user'],
				'nationalCode' => ['required', 'exists:user'],
				'captcha'      => ['required', 'captcha'],
			];

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				Input::flash();
				Session::flash('error', true);
				return Redirect::back()->withErrors($validator);
			}

			$user = User::where('mobile', Input::get('mobile'))->first();
			$user->reminderToken = User::reminderToken(Input::get('mobile'));
			$user->save();

			return Redirect::action('SeekerController@reset', [$user->reminderToken]);
		}

		return View::make('seeker.forget');
	}



	public function reset($token)
	{
		if (Request::isMethod('post'))
		{
			$rules = [
				'password'       => ['required'],
				'repeatPassword' => ['required'],
			];

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				Input::flash();
				Session::flash('error', true);
				return Redirect::back()->withErrors($validator);
			}

			$user = User::where('reminderToken', $token)->first();
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::action('SeekerController@reseted');
		}

		return View::make('seeker.reset');
	}



	public function reseted()
	{
		return View::make('seeker.reseted');
	}



	public function step1()
	{
		return View::make('seeker.step1');
	}



	public function step1Check()
	{
		$rules = [
			'name'           => 'required|max:45',
			'family'         => 'required|max:45',
			'gender'         => 'required|in:1,2',
			'mobile'         => ['required', 'regex:/^0?9\d{9}$/', 'unique:user'],
			//'nationalCode'   => 'required|nationalCode',
			'password'       => 'required|min:7',
			'passwordRepeat' => 'required|required_with:password',
			//'captcha'        => 'required|captcha',
			'agreement'      => 'required|in:1',
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
			return Redirect::back()->withErrors($validator);
		}

		// adding user
		$user = new User;

		$user->fill(Input::only(['name', 'family', 'gender', 'mobile', 'nationalCode']));

		$user->password         = Hash::make(Input::get('password'));
		$user->type             = User::TYPE_SEEKER;
		$user->registrationStep = User::REGISTRATION_STEP_ONE;

		$user->save();
		
		Session::set('register-user-id', $user->id);

		return Redirect::route('seeker.step2');
	}



	public function step2()
	{
		if (!Session::has('register-user-id'))
		{
			App::abort(404);
		}

		$user = User::find(Session::get('register-user-id'));

		$payment = new Payment;
		$payment->userId = $user->id;
		$payment->amount = 10000;
		$payment->save();

		Session::set('register-payment-id', $payment->id);

		return View::make('seeker.step2')
			->with('user', $user)
			->with('payment', $payment);
	}



	public function step2Purchase()
	{
		$payment = Payment::find(Session::get('register-payment-id'));

		//$user = User::find(Session::get('register-user-id'));

		$gateway = Payment\Payment::create('Jahanpay', [
			'terminalId'  => 'gt34117g539',
			'callbackUrl' => route('seeker.step3'),
		]);

		/*$gateway = Payment\Payment::create('Mellat', [
			'terminalId'  => 802802,
			'userName' => 'rahahost',
			"userPassword"   => 'ra94ha',
			'callbackUrl' => 'http://2.182.224.75/Payment/back.php',
		]);*/

		$purchase = $gateway->purchase($payment->amount, $payment->id);

		if ($purchase->send())
		{
			$token = $purchase->getToken();
			$payment->token = $token;
			$payment->save();

			$purchase->redirect();
		}
		else
		{
			$payment->requestCode = $purchase->getError()['code'];
			$payment->requestMessage = $purchase->getError()['message'];
			$payment->save();
		}
	}



	public function step3()
	{
		$gateway = Payment\Payment::create('Jahanpay', [
			'terminalId'  => 'gt34117g539',
			'callbackUrl' => 'http://caspeen.dev/purchase/verify',
		]);

		$receipt = $gateway->receipt();
		//$receipt = $gateway->capture();

		if ($receipt->isOk())
		{
			$data = $receipt->getData();

			//shomare kharid bayad yekta bashe && bablagh bayad barabar bashe

			if ($receipt->verify())
			{

				$p = Payment::find($data['order_id']);
				$p->status = Payment::STATUS_SUCCESS;
				$p->save();

				//Auth::loginUsingId($p->userId);

				Auth::user()->courses()->attach($p->courseId);

				$c = Course::find($p->courseId);

				return Redirect::route('course', $c->slug);
			}
			else
			{
				print_r($receipt->getError());
				//$receipt->reverse();
			}


		}
		else
		{
			print_r($receipt->getError());
		}
		
		return Input::all();
	}
}
