<?php

namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add(
                [
                    'text' => '',
                    'icon'    => 'flag-icon flag-icon-' . getFlagLanguage(),
                    'topnav_right' => true,
                    'submenu' => [
                        [
                            'text' => 'English',
                            'icon'    => 'flag-icon flag-icon-us',
                            'url'  => 'change-language/en',
                        ],
                        [
                            'text'    => '한국',
                            'icon'    => 'flag-icon flag-icon-kr',
                            'url'     => 'change-language/ko',
                        ],
                    ],
                ]
            );
        });
    }
}
