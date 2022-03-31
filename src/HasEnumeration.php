<?php

namespace DavidIanBonner\Enumerated;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

trait HasEnumeration
{
    public static function values(): array
    {
        return array_map(fn ($obj) => $obj->value, static::cases());
    }

    public static function collect(): Collection
    {
        return new Collection(static::values());
    }

    public static function toSelect(): Collection
    {
        return Collection::make(static::cases())->mapWithKeys(fn ($enum) => [
            $enum->value => $enum->line(),
        ]);
    }

    public static function exists($value): bool
    {
        return (bool) optional(static::tryFrom($value))->value;
    }

    public function line(): string
    {
        return Lang::get(
            implode('.', [
                $this->keyPrefix() . 'enum',
                static::key(),
                $this->value,
            ])
        );
    }

    public function keyPrefix(): string
    {
        return '';
    }
}
