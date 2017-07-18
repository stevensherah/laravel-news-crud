<?php

namespace Sevenpluss\NewsCrud\Prototypes;

/**
 * Class AbstractPrototype
 * @package Sevenpluss\NewsCrud\Prototypes
 */
abstract class AbstractPrototype
{
    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->{$name} = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->{$name};
    }

    /**
     * @param string $method
     * @param mixed $args
     * @return mixed
     */
    public function __call(string $method, $args): mixed
    {
        return call_user_func_array([$this, $method], $args);
    }

    /**
     * @param string $method
     * @param mixed $args
     * @return mixed
     */
    public static function __callStatic(string $method, $args): mixed
    {
        return call_user_func_array([self::class, $method], $args);
    }

    /**
     * @return string
     */
    public function __toString():string
    {
        return json_encode(get_object_vars($this));
    }
}
