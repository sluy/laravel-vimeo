<?php

namespace Vientodigital\LaravelVimeo;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use InvalidArgumentException;
use Vientodigital\LaravelVimeo\Video\Pagination;
use Vimeo\Vimeo;

class LaravelVimeo
{
    public function routes()
    {
        App::make('router')->name('laravel-vimeo')->resource('me', '\Vientodigital\LaravelVimeo\Http\Controllers\MeController');
    }

    public static function apiRoutes()
    {
    }

    public function getConfig(string $name = null): array
    {
        $raw = $this->getRawConfig($name);
        foreach (['client_id', 'client_secret'] as $required) {
            if (!array_key_exists($required, $raw)) {
                throw new InvalidArgumentException("Missing configuration key [{$required}].");
            }
        }

        return Arr::only($raw, ['client_id', 'client_secret', 'access_token']);
    }

    public function getRawConfig(string $name = null): array
    {
        if (empty($name)) {
            $name = 'default';
        }
        $cfgs = config('laravel-vimeo.accounts', []);

        if (is_array($cfgs) && !empty($cfgs)) {
            foreach ($cfgs as $current) {
                if (is_array($current) && isset($current['name']) && $current['name'] === $name) {
                    return $current;
                }
            }

            // looking in first element if $name is default.
            if ('default' === $name) {
                foreach ($cfgs as $current) {
                    if (is_array($current) && !empty($current)) {
                        return $current;
                    }
                }
            }
        }

        throw new Exception("Cant resolve {$name} connection.");
    }

    public function getClient(string $name = null)
    {
        $cfg = $this->getConfig($name);

        return new Vimeo(
            $cfg['client_id'],
            $cfg['client_secret'],
            $cfg['access_token']
        );
    }

    public function paginate($config = null)
    {
        if (!($config instanceof Repository)) {
            if (!is_array($config)) {
                $config = [];
            }
            $config = new Repository($config);
        }
        $client = $this->getClient($config->get('connection', 'default'));
        $paginationConfig = [
            'per_page' => $config->get('per_page', 10),
        ];

        $data = $client->request($config->get('route', '/me/videos'), $paginationConfig, 'GET');

        if (is_array($data) && isset($data['status']) && 200 === $data['status'] && isset($data['body']) && is_array($data['body'])) {
            $data = $data['body'];
        } else {
            $data = [];
        }

        return new Pagination($data);
    }
}
