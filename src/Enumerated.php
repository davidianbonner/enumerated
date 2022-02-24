<?php

namespace DavidIanBonner\Enumerated;

use Illuminate\Support\Collection;

interface Enumerated
{
    /**
     * Return the enum key.
     *
     * @return string
     */
    public static function key(): string;

    /**
     * Return the enumerators values.
     *
     * @return array
     */
    public static function values(): array;

    /**
     * Return a collection of the declared values.
     *
     * @return Collection
     */
    public static function collect(): Collection;

    /**
     * Return an array with the value and label as key and value.
     *
     * @return Collection
     */
    public static function toSelect(): Collection;

    /**
     * Return the language line for the enum.
     *
     * @return string
     */
    public function line(): string;
}
