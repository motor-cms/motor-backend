<?php

namespace Motor\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Motor\Backend\Lavary\Menu\Menu;

/**
 * Class BackendNavigation
 * @package Motor\Backend\Http\Middleware
 */
class BackendNavigation
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('', static function () {
        }); //  <-- we need to do this to load the deferred service provider as we're using our motor-backend class for the menu

        $menu = ( new Menu );

        //\Menu::make('backendNavigation', function ($menu) {
        $menu->make('backendNavigation', static function ($menu) {

            $items = config('motor-backend-navigation.items');
            ksort($items);

            foreach ($items as $item) {

                $menu->add(trans($item['name']), [
                    'route'       => Arr::get($item, 'route'),
                    'roles'       => implode(',', $item['roles']),
                    'permissions' => implode(',', $item['permissions']),
                    'aliases'     => implode(',', Arr::get($item, 'aliases', []))
                ])->nickname($item['slug'])->prepend('<i class="nav-icon ' . $item['icon'] . '"></i>');
                //])->nickname($item['slug'])->prepend('<i class="nav-icon ' . $item['icon'] . '"></i> <span>')->append('</span>');

                if (isset($item['items'])) {

                    $menu->get($item['slug'])->append(config('motor-backend-navigation.collapseIcon'));
                    //$menu->get($item['slug'])->append('</span> ' . config('motor-backend-navigation.collapseIcon'));

                    ksort($item['items']);

                    foreach ($item['items'] as $subitem) {

                        if (config('motor-backend-html.show_navigation_subitem_icon', false)) {
                            $menu->get($item['slug'])
                                 ->add(trans($subitem['name']), [
                                     'route' => $subitem['route'],
                                     'roles' => implode(',', $subitem['roles']),
                                     'permissions' => implode(',', $subitem['permissions']),
                                     'aliases' => implode(',', Arr::get($subitem, 'aliases', []))
                                 ])
                                 ->nickname($subitem['slug'])
                                 ->prepend('<i class="nav-icon ' . $subitem['icon'] . '"></i>');
                            //->prepend('<i class="nav-icon ' . $subitem['icon'] . '"></i> <span>')
                            //    ->append('</span>');
                        } else {
                            $menu->get($item['slug'])->add(trans($subitem['name']), [
                                'route'       => $subitem['route'],
                                'roles'       => implode(',', $subitem['roles']),
                                'permissions' => implode(',', $subitem['permissions']),
                                'aliases'     => implode(',', Arr::get($subitem, 'aliases', []))
                            ])->nickname($subitem['slug']);
                        }

                    }
                }
            }
        });

        return $next($request);
    }
}
