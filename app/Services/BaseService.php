<?php

namespace App\Services;

abstract class BaseService
{
    protected function validateTitle(array $data): string
    {
        if (isset($data['titulo ']))
            return $data['titulo '];

        if (isset($data['titulo']))
            return $data['titulo'];
    }
}
