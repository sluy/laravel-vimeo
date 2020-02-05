<?php

namespace Vientodigital\LaravelVimeo\Video;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Base
{
    protected $_cfg;

    public function __construct($config)
    {
        $this->_cfg = new Repository();
        $this->import($config);
    }

    public function __get($name)
    {
        $formatted = Str::snake($name);

        return $this->get($formatted);
    }

    public function __call($name, array $args)
    {
        $name = $this->formatName($name);
        $method = 'get'.Str::camel($name);
        if (Str::startsWith('get', $name) && strlen($name) > 3 && method_exists($this, 'get'.$name)) {
            return call_user_func_array([this, 'get'.$name], $args);
        }
        $formatted = Str::snake($name);

        return $this->get($formatted, isset($args[0]) ? $args[0] : null);
    }

    public function has($key)
    {
        return $this->_cfg->has($key);
    }

    public function get($name, $default = null)
    {
        return $this->_cfg->get($this->formatName($name), $default);
    }

    public function set($name, $value)
    {
        $name = $this->formatName($name);
        $this->_cfg->set($name, $value);

        return $this;
    }

    public function import($data)
    {
        foreach (func_get_args() as $current) {
            if ($current instanceof Repository) {
                $current = $current->all();
            }
            if (is_array($current)) {
                foreach (Arr::dot($current) as $name => $value) {
                    $this->set($name, $value);
                }
            }
        }

        return $this;
    }

    public function all()
    {
        return $this->_cfg->all();
    }

    protected function formatName($name)
    {
        return implode('.', array_map(function ($current) {
            return Str::snake($current);
        }, explode('.', $name)));
    }
}
