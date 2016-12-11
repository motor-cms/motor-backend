<?php

namespace Motor\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Motor\Backend\Lavary\Menu\Menu;

class BackendNavigation
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menu = new Menu;

        //\Menu::make('backendNavigation', function ($menu) {
        $menu->make('backendNavigation', function ($menu) {

            $items = config('motor-backend-navigation.items');
            ksort($items);

            foreach ($items as $key => $item) {

                $menu->add(trans($item['name']), [
                    'route'       => Arr::get($item, 'route'),
                    'roles'       => implode(',', $item['roles']),
                    'permissions' => implode(',', $item['permissions']),
                    'aliases'     => implode(',', Arr::get($item, 'aliases', []))
                ])->nickname($item['slug'])->prepend('<i class="' . $item['icon'] . '"></i> <span>')->append('</span>');

                if (isset($item['items'])) {

                    $menu->get($item['slug'])->append('</span> <i class="fa fa-angle-left pull-right"></i>');

                    ksort($item['items']);

                    foreach ($item['items'] as $subkey => $subitem) {
                        $menu->get($item['slug'])->add(trans($subitem['name']), [
                            'route'       => $subitem['route'],
                            'roles'       => implode(',', $subitem['roles']),
                            'permissions' => implode(',', $subitem['permissions']),
                            'aliases'     => implode(',', Arr::get($subitem, 'aliases', []))
                        ])->nickname($subitem['slug']);
                    }
                }
            }
        });

        return $next($request);
    }
}
