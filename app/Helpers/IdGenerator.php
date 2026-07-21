<?php

namespace App\Helpers;

class IdGenerator
{
    public static function generate(): string
    {
        return time() . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public static function generateFor(string $model): string
    {
        do {
            $id = self::generate();
        } while ($model::whereKey($id)->exists());

        return $id;
    }
}
