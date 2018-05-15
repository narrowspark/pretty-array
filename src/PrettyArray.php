<?php
declare(strict_types=1);
namespace Narrowspark\PrettyArray;

use Narrowspark\PrettyArray\Traits\PrettyArrayPrintTrait;

class PrettyArray
{
    use PrettyArrayPrintTrait;

    /**
     * Private constructor; non-instantiable.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Returns a pretty php array for saving or output.
     *
     * @param array $data
     * @param int   $indentLevel
     *
     * @return string
     */
    public static function print(array $data, int $indentLevel = 1): string
    {
        return self::getPrettyPrintArray($data, $indentLevel);
    }
}
