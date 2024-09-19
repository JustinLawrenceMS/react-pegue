<?php

namespace App\Http\Middleware;

use App\Models\Citation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => [
                    'can' => [
                        'createCitations' => Auth::user() ? Auth::user()->can('create', new Citation()) : null,
                    ],
                    'citations' => Auth::user() ? Auth::user()->citations : null,
                    'jsonCitations' => Auth::user() ? Auth::user()->jsonCitations() : null,
                ]
            ],
        ]);
    }
}
