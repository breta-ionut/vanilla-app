<?php

declare(strict_types=1);

namespace App\Core\Database;

trait ColumnsToPropertiesMapperTrait
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __set(string $name, mixed $value): void
    {
        $camelizedName = \strtr(\ucwords(\strtr($name, ['_' => ' ', '.' => '_ ', '\\' => '_ '])), [' ' => '']);

        if (!\property_exists($this, $camelizedName)) {
            throw new \InvalidArgumentException(\sprintf('Could not find a corresponding property for "%s".', $name));
        }

        $this->{$camelizedName} = $value;
    }
}
