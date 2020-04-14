<?php

namespace console\component;

/**
 * Base class to be used by all of the console controllers.
 */
class Controller extends \yii\console\Controller
{

    /**
     * Enables force mode
     *
     * @var bool
     */
    public $force = false;

    /**
     * Enables silent mode, nothing will be send to output
     *
     * @var bool
     */
    public $silent = false;

    /**
     * Enables verbose output mode
     *
     * @var bool
     */
    public $verbose = false;

    /**
     * Overrides import source files
     * @var string
     */
    public $source = null;

    /**
     * if this is daemon thread we will use this value to write this to daemon output instead of default stdout
     * @var int
     */
    public $queueId = null;

    /**
     * used to collect messages when queueId not null and send them to logs
     * @var array
     */
    protected $messages = [];

    public function options($actionID)
    {
        return ['force', 'silent', 'verbose', 'source', 'queueId',];
    }

    public function optionAliases()
    {
        return [
            'f' => 'force',
            's' => 'silent',
            'v' => 'verbose',
        ];
    }

    /**
     * This intercepts the output and send a copy of it to the "logCron" method.
     *
     * @param string $string
     * @return int|boolean Number of bytes printed or false on error
     */
    public function stdout($string)
    {
        if ($this->silent) {
            return null;
        }

        if ($this->queueId) {
            $this->messages[] = ['message' => $string, 'level' => 0, 'queue_id' => $this->queueId];
            return null;
        }

        return parent::stdout($string . PHP_EOL);
    }

    /**
     * This intercepts the output and send a copy of it to the "logCron" method.
     *
     * @param string $string
     * @return int|boolean Number of bytes printed or false on error
     */
    public function stderr($string)
    {
        if ($this->queueId) {
            $this->messages[] = ['message' => $string, 'level' => 1, 'queue_id' => $this->queueId];
            return null;
        }

        return parent::stderr($string . PHP_EOL);
    }
}
