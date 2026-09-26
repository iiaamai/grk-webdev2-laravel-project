<?php

namespace App\Models;

use App\Models\Concerns\Archivable;
use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'setting_key',
    'setting_value',
])]
class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use Archivable, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'archived_at' => 'datetime',
        ];
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $setting = static::query()->where('setting_key', $key)->first();

        return $setting?->setting_value ?? $default;
    }

    public static function setValue(string $key, ?string $value): static
    {
        return static::query()->updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value],
        );
    }
}
