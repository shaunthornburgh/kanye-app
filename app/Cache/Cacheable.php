<?php

namespace App\Cache;

use Illuminate\Support\Collection;

interface Cacheable
{
    public function get(string $key, int $count): Collection;
    public function put(string $key, Collection $value, int $minutes): void;
}
