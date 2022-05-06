<?php

namespace App\Hr\Transformers;

abstract class Transformer
{
    public function transformCollection(array $items): array
    {
        return array_map([$this, 'transform'], $items);
    }

    abstract public function transform($item);
}
