<?php

class Sms extends Eloquent
{

	protected $table = 'sms';



	public static function send($message, $to, $userId = null)
	{
		$sms = new static;
		$sms->message = $message;
		$sms->to      = $to;
		$sms->userId  = $userId;
		$sms->date    = date('Y-m-d H:i:s');
	}
}
