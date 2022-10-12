<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\Cache;

abstract class BaseService
{
    /**
     * This method will cache the collection and save the query as they key
     * @param string name
     * @param Closure $callback
     * @param array $attributes
     * @param int $expiration [default 1 day]
     */
    public function cahceByAttributes(string $name, Closure $callback, array $attributes = [], int $expiration = (60*60*24))
    {
        if (! empty($attributes))
            $cacheString = http_build_query($attributes, "", "-");
        else
            $cacheString = '';

        return Cache::remember($name.$cacheString, $expiration, $callback);
    }

    protected function validateTitle(array $data): string
    {
        if (isset($data['titulo ']))
            return $data['titulo '];

        if (isset($data['titulo']))
            return $data['titulo'];
    }
}
