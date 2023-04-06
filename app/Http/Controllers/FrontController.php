<?php

namespace App\Http\Controllers;

use App\Helpers\GtmHelpers;
use App\Http\Controllers\Helpers\Seo;
use A17\Twill\Http\Controllers\Front\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class FrontController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->seo = new Seo();
        $this->seo->title = config('twill.seo.site_title');
        $this->seo->description = config('twill.seo.site_desc');
        $this->seo->image = config('twill.seo.image');
        $this->seo->width = config('twill.seo.width');
        $this->seo->height = config('twill.seo.height');

        View::share('seo', $this->seo);

        $this->loadSearchTerms();
        $this->loadBaseSeo();
    }

    protected function loadSearchTerms()
    {
        $terms = \App\Models\SearchTerm::ordered()->limit(10)->get();
        View::share('searchTerms', $terms);
    }

    protected function loadBaseSeo()
    {
        View::share('globalSuffix', 'The Art Institute of Chicago');
    }

    protected function getCanonicalRedirect($canonicalPath)
    {
        if (config('aic.is_preview_mode')) {
            return;
        }

        if (!Str::endsWith($canonicalPath, request()->path())) {
            return redirect($canonicalPath, 301);
        }
    }

    /**
     * WEB-2436: For `page-meta-data` events in GTM/GA4. Per discussion:
     *  - Booleans should be 'yes' or 'no'
     *  - Empty string '' is preferred to `null`
     */
    protected function getPageMetaData($item)
    {
        return json_encode(
            GtmHelpers::getTransformedMetaData(
                $this->setPageMetaData($item)
            )
        );
    }
    public function authorize($request)
    {
        $configuredUsername = config('aic.http_username');
        $configuredPassword = config('aic.http_password');

        if (empty($configuredUsername) || empty($configuredPassword)) {
            return abort(500, 'Basic authentication not configured.');
        }

        $authenticationHasPassed = false;
        $username = $request->header('PHP_AUTH_USER', null);
        $password = $request->header('PHP_AUTH_PW', null);

        if ($username && $password) {
            if ($username === $configuredUsername && $password === $configuredPassword) {
                $authenticationHasPassed = true;
            }
        }

        if (!$authenticationHasPassed) {
            return response()->make('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
        }
    }
}
