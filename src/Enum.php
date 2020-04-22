<?php

namespace DavidIanBonner\Enumerated;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use ReflectionClass;

abstract class Enum
{
    /** @var string */
    private $value;

    /** @var array */
    private static $loaded = [];

    /** @var array */
    protected static $values = [];

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * Return the enumerators values.
     *
     * @param bool $keys
     * @return array
     */
    public static function allValues($keys = false): array
    {
        $caller = get_called_class();

        if (! isset(static::$values[$caller])) {
            static::$values[$caller] = static::getDeclaredConstants();
        }

        return $keys ? static::$values[$caller] : array_values(static::$values[$caller]);
    }

    /**
     * Return a collection of the declared values.
     *
     * @param  bool $keys
     * @return Illuminate\Support\Collection
     */
    public static function collect($keys = false): Collection
    {
        return Collection::make(static::allValues($keys));
    }

    /**
     * Return an instance of a desired value.
     *
     * @param  string $value
     * @return DavidIanBonner\Enumerated\Enum
     */
    public static function ofType($value): self
    {
        $key = get_called_class() . ':' . $value;

        if (! isset(self::$loaded[$key])) {
            self::$loaded[$key] = new static($value);
        }

        // We can safely return the instance from the loaded array as
        // validation is carried out in the constructor and the
        // $loaded property is private.

        return self::$loaded[$key];
    }

    /**
     * Return the value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Validate the value.
     *
     * @param  mixed $value
     * @throws DavidIanBonner\Enumerated\EnumNotValidException
     * @return void
     */
    public static function validateValue($value)
    {
        if (! in_array($value, static::allValues())) {
            throw new EnumNotValidException("The value [{$value}] is not a valid type.");
        }
    }

    /**
     * Check the value is valid and return a bool.
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        try {
            static::validateValue($value);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get the declared constants.
     *
     * @return array
     */
    protected static function getDeclaredConstants(): array
    {
        $reflection = new ReflectionClass(get_called_class());

        return (array) $reflection->getConstants();
    }

    /**
     * @return array
     */
    public static function toSelect(): array
    {
        return static::collect()
            ->mapWithKeys(function ($key) {
                $outcome = self::ofType($key);

                return [$outcome->value() => $outcome->line()];
            })
            ->toArray();
    }

    /**
     * @return string
     */
    public function line(): string
    {
        $vendor = $this->vendor() ?: null;

        return Lang::get(
            ($vendor?$vendor.'::':'').'enum.'.$this->langKey().'.'.str_replace('_', '-', $this->value())
        );
    }

    public abstract function langKey(): string;

    public function vendor()
    {
        return null;
    }
}
