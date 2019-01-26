<?php declare(strict_types=1);

namespace Phlam;

class Runner
{
    const POST = 'POST';
    const GET = 'GET';
    const AWS_LAMBDA_RUNTIME_API = 'AWS_LAMBDA_RUNTIME_API';
    const LAMBDA_TASK_ROOT = 'LAMBDA_TASK_ROOT';
    const HANDLER = '_HANDLER';

    private $runtimeApiUrl;

    /**
     * Runner constructor.
     * @throws Exception\EnvNotFoundException
     */
    public function __construct()
    {
        $runtimeApiUrl = getenv(self::AWS_LAMBDA_RUNTIME_API);
        if (!$runtimeApiUrl) {
            throw new Exception\EnvNotFoundException(self::AWS_LAMBDA_RUNTIME_API . ' env variable not found');
        }
        $this->runtimeApiUrl = "https://" . $runtimeApiUrl;

        $functionCodePath = getenv(self::LAMBDA_TASK_ROOT);
        if (!$functionCodePath) {
            throw new Exception\EnvNotFoundException(self::LAMBDA_TASK_ROOT . ' env variable not found');
        }

        $handler = getenv(self::HANDLER);
        if (!$handler) {
            throw new Exception\EnvNotFoundException(self::HANDLER . ' env variable not found');
        }
    }
}