<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SidebarBlocksController;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $obj = new SettingController();
        $settings = $obj->getAllSettings();

        $mode = $settings->paypal_mode;
        $s_client_id = $settings->paypal_sandbox_client_id;
        $s_client_secret = $settings->paypal_sandbox_client_secret;
        $l_client_id = $settings->paypal_live_client_id;
        $l_client_secret = $settings->paypal_live_client_secret;
        Config::set('paypal.mode', $mode);
        Config::set('paypal.sandbox.client_id', $s_client_id);
        Config::set('paypal.sandbox.client_secret', $s_client_secret);
        Config::set('paypal.live.client_id', $l_client_id);
        Config::set('paypal.live.client_secret', $l_client_secret);

        view()->composer('*', function ($view) use ($settings) {
            $currCountry = array();
            $sTextBlocks = null;
            $sAppBlocks = null;
            $header_menus = "";
            $footer_menus = "";
            $pageObj = new PageController();
            $menus = $pageObj->getMenus();
            $header_menus = $menus['header_menus'];
            $footer_menus = $menus['footer_menus'];

            $obj = new Controller();
            $segment = request()->segment(1);
            $adminSegment = request()->segment(2);
            if (!$adminSegment) {
                $adminSegment = "aus";
            }
            // $index1 = array_search($adminSegment, array_column($obj->countries, 'short'));
            // $adminCountry = $obj->countries[$index1];
            $countriesCollection = collect($obj->countries);
            $filteredCountries = $countriesCollection->where('short', $adminSegment);
            $adminCountry = $filteredCountries->values()->first();

            //
            if (!$segment) {
                $segment = "aus";
            }
            $countriesCollection = collect($obj->countries);
            $filteredCountries = $countriesCollection->where('short', $segment);
            $currCountry = $filteredCountries->values()->first();
            // $index = array_search($segment, array_column($obj->countries, 'short'));
            // $currCountry = $obj->countries[$index];

            $common = (object)[
                'countries' => $obj->countries,
                'currCountry' => $currCountry,
                'adminCountry' => $adminCountry,
                'header_menus' => $header_menus,
                'footer_menus' => $footer_menus,
            ];


            $blockObj = new SidebarBlocksController();
            $blocks = $blockObj->getSideBlocks();
            if ($blocks) {
                if (isset($blocks['text'])) {
                    $sTextBlocks = $blocks['text'];
                }
                if (isset($blocks['app'])) {
                    $sAppBlocks = $blocks['app'];
                }
            }
            $view->with(['common' => $common, 'site_settings' => $settings, 'sTextBlocks' => $sTextBlocks, 'sAppBlocks' => $sAppBlocks]);
        });
        Paginator::useBootstrap();
    }
}
