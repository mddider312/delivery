<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Language extends BaseController
{
	public function index()
	{
		$session = session();
        $locale = service('request')->getLocale();
        $session->remove('lang');
        $session->set('lang',$locale);
        return redirect()->back(); 
	}
}
