<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = ['name', 'family', 'gender', 'mobile', 'nationalCode'];


	const TYPE_SEEKER     = 0;
	const TYPE_ADVERTISER = 1;
	const TYPE_ADMIN      = 2;


	const REGISTRATION_STEP_ONE = 1;


	public function roles()
	{
		return;
	}



	public function can($capability, $data = null)
	{
		# code...
	}



	public function smses()
	{
		return $this->hasMany('Sms', 'userId');
	}



	public function sendSms($message)
	{
		Sms::send($message, $this->mobile, $this->id);
	}



	public function sendEmail()
	{
		/*Mail::send('hello', [], function($message)
		{
			$message->to('rezakho@gmail.com', 'John Smith')->subject('Welcome!');
		});*/
	}



	public static function reminderToken($mobile)
	{
		$key = Config::get('app.key');

		$value = str_shuffle(sha1($mobile./*spl_object_hash($this).*/microtime(true)));

		return hash_hmac('sha1', $value, $key);
	}
}
