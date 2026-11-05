<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operations\RedirectToLocaleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class RedirectToLocaleController extends Controller
{
    /**
     * Redirect a URL without a language to the same path in the preferred language.
     */
    public function __invoke(RedirectToLocaleRequest $request): RedirectResponse
    {
        $path = trim($request->route('area').'/'.App::getLocale().'/'.$request->route('path'), '/');
        $query = $request->getQueryString();

        return redirect('/'.$path.($query !== null ? '?'.$query : ''));
    }
}
