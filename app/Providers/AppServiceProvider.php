<?php

namespace App\Providers;

use App\Models\Cashout;
use App\Models\Contact;
use App\Models\Donation;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });

        view()->composer('layouts.partials.header', function ($view) {
            $listNotifikasi = [
                'donatur' => User::donatur()->get(), // ->whereDate('created_at', date('Y-m-d'))
                'subscriber' => Subscriber::get(), // whereDate('created_at', date('Y-m-d'))->
                'contact' => Contact::get(), // whereDate('created_at', date('Y-m-d'))->
                'donation' => Donation::get(), // whereDate('created_at', date('Y-m-d'))->
                'cashout' => Cashout::get(), // whereDate('created_at', date('Y-m-d'))->
            ];

            if (auth()->user()->hasRole('donatur')) {
                $listNotifikasi = [
                    'donation' => Donation::donatur()->get(), // whereDate('created_at', date('Y-m-d'))->
                    'cashout' => Cashout::donatur()->get(), // whereDate('created_at', date('Y-m-d'))->
                ];
            }

            $countNotifikasi = collect($listNotifikasi)->map(fn ($item) => $item->count())->sum();
    
            $listNotifikasi = collect($listNotifikasi)
                ->map(fn ($item) => $item->push($item->count()))
                ->map(function ($item, $key) {
                    $attributes = $item->sortByDesc('created_at')->first();
                    if ($item->sortByDesc('created_at')->last()) {
                        $attributes->$key = $item->sortByDesc('created_at')->last();
                    }

                    return $attributes;
                })
                ->sortByDesc(fn ($item) => $item->created_at ?? '');
            
            $view->with('listNotifikasi', $listNotifikasi);
            $view->with('countNotifikasi', $countNotifikasi);
        });
    }
}
