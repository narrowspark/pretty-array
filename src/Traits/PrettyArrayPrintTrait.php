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
                if (\is_string($key) && (\class_exists($key) || \interface_exists($key)) && \ctype_upper($key[0])) {
                    $key = \sprintf('\\%s::class', \ltrim($key, '\\'));
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

        if (\is_string($value) && (\class_exists($value) || \interface_exists($value)) && \ctype_upper($value[0])) {
            return \sprintf('\\%s::class', \ltrim($value, '\\'));
        }

        if (\is_numeric($value)) {
            if (\is_string($value)) {
                return \sprintf("'%s'", $value);
            }

            return (string) $value;
        }

        return \var_export($value, true);
    }
}
