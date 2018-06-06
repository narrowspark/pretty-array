<?php
declare(strict_types=1);
namespace Narrowspark\PrettyArray;

class PrettyArray
{
    /**
     * The default resolver for the array values.
     *
     * @see http://php.net/manual/en/function.gettype.php
     *
     * @var array
     */
    protected static $defaultResolverCallbacks = [];

    /**
     * Create a new PrettyArray instance.
     */
    public function __construct()
    {
        self::$defaultResolverCallbacks = [
            'class' => function ($value) {
                $class = \str_replace('\\\\', '\\', $value);
                $class = \sprintf('%s::class', $class);

                return \mb_strpos($class, '\\') === 0 ? $class : '\\' . $class;
            },
            'integer' => function ($value) {
                return (string) $value;
            },
            'double' => function ($value) {
                return (string) $value;
            },
        ];
    }

    /**
     * Returns a pretty php array for saving or output.
     *
     * @param array $data
     * @param int   $indentLevel
     * @param array $resolverCallbacks
     *
     * @return string
     */
    public function print(array $data, int $indentLevel = 1, array $resolverCallbacks = []): string
    {
        $indent  = \str_repeat(' ', $indentLevel * 4);
        $entries = [];

        if (! isset($resolverCallbacks['__resolved__'])) {
            $resolverCallbacks = \array_merge(self::$defaultResolverCallbacks, $resolverCallbacks);

            $resolverCallbacks['__resolved__'] = true;
        }

        foreach ($data as $key => $value) {
            if (! \is_int($key)) {
                if (self::isClass($key)) {
                    $key = $resolverCallbacks['class']($key);
                } else {
                    $key = \sprintf("'%s'", $key);
                }
            }

            $entries[] = \sprintf(
                '%s%s%s,',
                $indent,
                \sprintf('%s => ', $key),
                self::createValue($value, $indentLevel, $resolverCallbacks)
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
     * @param array $resolverCallbacks
     *
     * @return string
     */
    protected function createValue($value, int $indentLevel, array $resolverCallbacks): string
    {
        $type = \gettype($value);

        if ($type === 'array') {
            return $this->print($value, $indentLevel + 1, $resolverCallbacks);
        }

        if (self::isClass($value)) {
            return $resolverCallbacks['class']($value);
        }

        if (isset($resolverCallbacks[$type])) {
            return $resolverCallbacks[$type]($value);
        }

        return \var_export($value, true);
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
