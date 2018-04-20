<?php
namespace Acme\LogProblem\Command;

use Acme\LogProblem\Log\ProblemLoggerInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Neos\Flow\Log\Backend\AnsiConsoleBackend;
use Neos\Flow\Log\ThrowableLoggerInterface;

/**
 * @Flow\Scope("singleton")
 */
class LogCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var ProblemLoggerInterface
     */
    protected $problemLogger;

    /**
     * @param string $exceptionMessage
     */
    public function doLogCommand(string $exceptionMessage)
    {
        $this->problemLogger->addBackend(new AnsiConsoleBackend());
        $this->problemLogger->log('Logger works');
        if ($this->problemLogger instanceof ThrowableLoggerInterface) {
            $this->problemLogger->log('Now the exception should be logged, but won\'t');
            $this->problemLogger->logThrowable(new \Exception($exceptionMessage));
        }
    }
}
