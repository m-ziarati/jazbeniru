<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function(){

	return Redirect::route('seeker.signup');
});


Route::get('email', function()
{
	Mail::send('hello', [], function($message)
	{
		$message->to('rezakho@gmail.com', 'John Smith')->subject('Welcome!');
	});
});


Route::group(['prefix' => 'user'], function()
{
	Route::group(['prefix' => 'account', 'before' => 'auth'], function()
	{
		//Route::get('/', ['uses' => 'AdminController@index']);
	});

	Route::get('registration/step1', ['as' => 'seeker.step1', 'uses' => 'SeekerController@step1']);
	Route::post('registration/step1/check', ['as' => 'seeker.step1.check', 'uses' => 'SeekerController@step1Check']);
	Route::get('registration/step2', ['as' => 'seeker.step2', 'uses' => 'SeekerController@step2']);
	Route::get('registration/step2/purchase', ['as' => 'seeker.step2.purchase', 'uses' => 'SeekerController@step2Purchase']);
	Route::any('registration/step3', ['as' => 'seeker.step3', 'uses' => 'SeekerController@step3']);

	Route::get('login', ['uses' => 'SeekerController@login']);
	Route::post('auth', ['uses' => 'SeekerController@auth']);
	Route::any('forget', ['uses' => 'SeekerController@forget']);
	Route::any('reset/{token}', ['uses' => 'SeekerController@reset']);
	Route::get('reseted', ['uses' => 'SeekerController@reseted']);
});



Route::get('serial', function()
{
	//Session::flash('test', 100);
	var_dump(Session::has('test'));
	return;
	$o = new User;
	$o->x = ['order' => '1', 'value' => '111'];

	foreach ([true, 1, 1.1, '1', "1", ['1' ,2, "str", "r" => '1111', 'f' => $o]] as $key => $value)
	{
		echo serialize($value);
		echo "<br/>";
	}
});


App::missing(function($exception)
{
    return Response::view('errors.404', array(), 404);
});


Route::get('crawl', function()
{
	set_time_limit(0);

	/*$c = new CrawlerE;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			$e->date  = $date;

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});*/



	/*$c = new CrawlerS;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			$e->date  = $date;

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});
	*/


	/*$c = new CrawlerI;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			$e->date  = $date;

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});*/



	/*$c = new CrawlerEs;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			//$e->date  = $date;

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});*/



	/*$c = new Crawler7010;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date, $tags)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			$e->date  = $date;
			$e->extraText  = json_encode($tags);

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});*/



	/*$c = new CrawlerHam1;

	$dublicate = 0;

	$c->fetchPageLinks(function($title, $url, $date, $tags)use (&$dublicate)
	{
		try
		{
			$e = new Entry;
			$e->title = $title;
			$e->url   = $url;
			$e->hash  = sha1($url);
			$e->date  = $date;
			$e->extraText  = json_encode($tags);

			$e->save();

			echo "New enrty inserted: [". $url ."]\n";
		}
		catch (Exception $e)
		{
			echo "Duplicat enrty: [". $url ."]\n";

			$dublicate++;

			if ($dublicate >= 10)
			{
				echo "Duplicate enrties are more than 10, fetching finished.";

				return false;
			}
		}
	});*/


	foreach (Entry::whereNull('text')->get() as $entry)
	{
		$entry->text = $c->fetchContent($entry->url);
		$entry->save();
	}
});
