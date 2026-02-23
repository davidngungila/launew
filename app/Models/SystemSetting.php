<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getValue(string $key, $default = null)
    {
        $row = static::query()->where('key', $key)->first();
        if (!$row) {
            return $default;
        }

        return $row->value ?? $default;
    }

    public static function setValue(string $key, $value): self
    {
        return static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
