<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Language;
use App\Models\System;

class FrontendController extends Controller
{
    protected $language;
    protected $systemRepository;
    protected $system;

    public function __construct(
        // SystemRepository $systemRepository
    ){

        $this->setLanguage();
        $this->setSystem();

    }

    public function setLanguage(){
        $locale = app()->getLocale(); // vn en cn
        // $language = Language::where('canonical', $locale)->first();
        $this->language = 1;
    }

    /**
     * Site settings, resolved once per request per language.
     *
     * RouterController resolves the target controller with app() and then calls
     * setSystem() on it by hand — controller constructors do not get the middleware
     * treatment for a manually resolved instance. Its own constructor has already
     * called setSystem() on itself by then, so without this cache every frontend
     * page read the whole systems table twice.
     *
     * scoped() rather than a static array: a static would live for the entire PHP
     * process, so a long-running worker would keep serving settings from before an
     * admin edited them.
     */
    public function setSystem(){
        $key = 'frontend.system.'.$this->language;

        if (!app()->bound($key)) {
            app()->scoped($key, function () {
                return convert_array(
                    System::where('language_id', $this->language)->get(), 'keyword', 'content'
                );
            });
        }

        $this->system = app($key);
    }
   

}
