<?php declare(strict_types=1);

namespace Test\Phlam;

use Phlam\Exception\EnvNotFoundException;
use Phlam\Runner;
use PHPUnit\Framework\TestCase;

class RunnerTest extends TestCase
{
    /** @var Runner */
    private $runner;

    public function setUp(): void
    {
        putenv(Runner::AWS_LAMBDA_RUNTIME_API . '=runtime-api.com');
        putenv(Runner::LAMBDA_TASK_ROOT . '=task-root');
        putenv(Runner::HANDLER . '=handler');

        $this->runner = new Runner();
    }

    public function nonExistentEnvVariableDataProvider()
    {
        return [
            [Runner::AWS_LAMBDA_RUNTIME_API],
            [Runner::LAMBDA_TASK_ROOT],
            [Runner::HANDLER],
        ];
    }

    /**
     * @dataProvider nonExistentEnvVariableDataProvider
     * @throws EnvNotFoundException
     */
    public function testNonExistentEnvVariableThrowsException($envVariable)
    {
        putenv($envVariable . '=');

        self::expectException(EnvNotFoundException::class);
        self::expectExceptionMessage($envVariable . ' env variable not found');

        new Runner();
    }

}
