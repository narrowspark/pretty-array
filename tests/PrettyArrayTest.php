<?php
declare(strict_types=1);
namespace Narrowspark\PrettyArray\Test;

use Exception;
use Narrowspark\PrettyArray\PrettyArray;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @internal
 */
final class PrettyArrayTest extends TestCase
{
    public function arrayOutProvider(): array
    {
        return [
            [[], '[' . \PHP_EOL . \PHP_EOL . ']'],
            [[1], '[' . \PHP_EOL . '    0 => 1,' . \PHP_EOL . ']'],
            [[1, 2, 3], '[' . \PHP_EOL . '    0 => 1,' . \PHP_EOL . '    1 => 2,' . \PHP_EOL . '    2 => 3,' . \PHP_EOL . ']'],
            [[1, '2', 3], '[' . \PHP_EOL . '    0 => 1,' . \PHP_EOL . '    1 => \'2\',' . \PHP_EOL . '    2 => 3,' . \PHP_EOL . ']'],
            [['foo' => 1, [2, 3]], '[' . \PHP_EOL . '    \'foo\' => 1,' . \PHP_EOL . '    0 => [' . \PHP_EOL . '        0 => 2,' . \PHP_EOL . '        1 => 3,' . \PHP_EOL . '    ],' . \PHP_EOL . ']'],
            [[1 => ['foo'], 'bar' => 2], '[' . \PHP_EOL . '    1 => [' . \PHP_EOL . '        0 => \'foo\',' . \PHP_EOL . '    ],' . \PHP_EOL . '    \'bar\' => 2,' . \PHP_EOL . ']'],
            [['\\Exception', '\\\\' . Exception::class], '[' . \PHP_EOL . '    0 => \\Exception::class,' . \PHP_EOL . '    1 => \\Exception::class,' . \PHP_EOL . ']'],
            [[1 => Exception::class, Throwable::class => 'error', 'foo' => 'bar', 'fooa' => 1.2], '[' . \PHP_EOL . '    1 => \\Exception::class,' . \PHP_EOL . '    \\Throwable::class => \'error\',' . \PHP_EOL . '    \'foo\' => \'bar\',' . \PHP_EOL . '    \'fooa\' => 1.2,' . \PHP_EOL . ']'],
            [[1 => 'foo', '188.29614911019327165' => 'bar', 'foo' => '889614911019327165', 'fooa' => 18896141256], '[' . \PHP_EOL . '    1 => \'foo\',' . \PHP_EOL . '    \'188.29614911019327165\' => \'bar\',' . \PHP_EOL . '    \'foo\' => \'889614911019327165\',' . \PHP_EOL . '    \'fooa\' => 18896141256,' . \PHP_EOL . ']'],
        ];
    }

    /**
     * @dataProvider arrayOutProvider
     *
     * @param array  $array
     * @param string $expected
     */
    public function testConvertsValueToValidPhp($array, $expected): void
    {
        $this->assertEquals($expected, PrettyArray::print($array));
    }
}
