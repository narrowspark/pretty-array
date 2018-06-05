<?php
declare(strict_types=1);
namespace Narrowspark\PrettyArray\Traits;

trait PrettyArrayPrintTrait
{
    /**
     * Returns a pretty php array for saving or output.
     *
     * @param array $data
     * @param int   $indentLevel
     *
     * @return string
     */
    protected static function getPrettyPrintArray(array $data, int $indentLevel = 1): string
    {
        $indent  = \str_repeat(' ', $indentLevel * 4);
        $entries = [];

        foreach ($data as $key => $value) {
            if (! \is_int($key)) {
                if (self::isClass($key)) {
                    $key = self::dumpLiteralClass($key);
                } else {
                    $key = \sprintf("'%s'", $key);
                }
            }

            $entries[] = \sprintf(
                '%s%s%s,',
                $indent,
                \sprintf('%s => ', $key),
                self::createValue($value, $indentLevel)
            );
        }

        $outerIndent = \str_repeat(' ', ($indentLevel - 1) * 4);

        return \sprintf('[' . \PHP_EOL . '%s' . \PHP_EOL . '%s]', \implode(\PHP_EOL, $entries), $outerIndent);
    }

    /**
     * Create the right value.
     *
     * @param mixed $value
     * @param int   $indentLevel
     *
     * @return string
     */
    protected static function createValue($value, int $indentLevel): string
    {
        if (\is_array($value)) {
            return self::getPrettyPrintArray($value, $indentLevel + 1);
        }

        if (self::isClass($value)) {
            return self::dumpLiteralClass($value);
        }

        if (\is_numeric($value)) {
            if (\is_string($value)) {
                return \sprintf("'%s'", $value);
            }

            return (string) $value;
        }

        return \var_export($value, true);
    }

    /**
     * Dumps a string to a literal (aka PHP Code) class value.
     *
     * @param string $class
     *
     * @return string
     */
    private static function dumpLiteralClass(string $class): string
    {
        $class = \str_replace('\\\\', '\\', $class);
        $class = \sprintf('%s::class', $class);

        return \mb_strpos($class, '\\') === 0 ? $class : '\\' . $class;
    }

    /**
     * Check if entry is a class.
     *
     * @param mixed $key
     *
     * @return bool
     */
    private static function isClass($key): bool
    {
        if (! \is_string($key)) {
            return false;
        }

        $key       = \ltrim($key, '\\');
        $firstChar = \mb_substr($key, 0, 1);

        return (\class_exists($key) || \interface_exists($key)) && \mb_strtolower($firstChar) !== $firstChar;
    }
}
