<?php namespace Pensoft\DemonstrationProjects;

use Backend;
use System\Classes\PluginBase;
use Twig\TwigFilter;

/**
 * DemonstrationProjects Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'DemonstrationProjects',
            'description' => 'No description provided yet...',
            'author'      => 'Pensoft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
        // Register custom filter for converting embedded videos
        \Event::listen('cms.page.beforeDisplay', function($controller, $url, $page) {
            $twig = $controller->getTwig();
            $twig->addFilter(new \Twig\TwigFilter('youtube_embed', function ($url) {
                preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w\-]+)/', $url, $matches);
                $videoId = $matches[1] ?? null;
                return $videoId ? "https://www.youtube.com/embed/$videoId" : null;
            }));
        });
    }
    

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Pensoft\DemonstrationProjects\Components\DemonstrationProjectsList' => 'demoList',
            'Pensoft\DemonstrationProjects\Components\DemonstrationProjectsItem' => 'demoItem',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'pensoft.demonstrationprojects.some_permission' => [
                'tab' => 'DemonstrationProjects',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'demonstrationprojects' => [
                'label'       => 'Demo Projects',
                'url'         => Backend::url('pensoft/demonstrationprojects/demonstrationprojects'),
                'icon'        => 'icon-flask',
                'permissions' => ['pensoft.demonstrationprojects.*'],
                'order'       => 500,
            ],
        ];
    }
}
