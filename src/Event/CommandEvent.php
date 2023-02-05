<?php

namespace Angle\PheanstalkBundle\Event;

use Pheanstalk\Contract\PheanstalkInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CommandEvent extends Event
{
    public const BURY = 'angle.pheanstalk.event.bury';
    public const DELETE = 'angle.pheanstalk.event.delete';
    public const IGNORE = 'angle.pheanstalk.event.ignore';
    public const KICK = 'angle.pheanstalk.event.kick';
    public const KICK_JOB = 'angle.pheanstalk.event.kick_job';
    public const LIST_TUBE_USED = 'angle.pheanstalk.event.list_tube_used';
    public const LIST_TUBES = 'angle.pheanstalk.event.list_tubes';
    public const LIST_TUBES_WATCHED = 'angle.pheanstalk.event.list_tubes_watched';
    public const PAUSE_TUBE = 'angle.pheanstalk.event.pause_tube';
    public const RESUME_TUBE = 'angle.pheanstalk.event.resume_tube';
    public const PEEK = 'angle.pheanstalk.event.peek';
    public const PEEK_READY = 'angle.pheanstalk.event.peek_ready';
    public const PEEK_DELAYED = 'angle.pheanstalk.event.peek_delayed';
    public const PEEK_BURIED = 'angle.pheanstalk.event.peek_buried';
    public const PUT = 'angle.pheanstalk.event.put';
    public const RELEASE = 'angle.pheanstalk.event.release';
    public const RESERVE = 'angle.pheanstalk.event.reserve';
    public const RESERVE_WITH_TIMEOUT = 'angle.pheanstalk.event.reserve_with_timeout';
    public const STATS = 'angle.pheanstalk.event.stats';
    public const STATS_TUBE = 'angle.pheanstalk.event.stats_tube';
    public const STATS_JOB = 'angle.pheanstalk.event.stats_job';
    public const TOUCH = 'angle.pheanstalk.event.touch';
    public const USE_TUBE = 'angle.pheanstalk.event.use_tube';
    public const WATCH = 'angle.pheanstalk.event.watch';
    public const WATCH_ONLY = 'angle.pheanstalk.event.watch_only';

    /**
     * @var PheanstalkInterface
     */
    private $pheanstalk;

    /**
     * @var array
     */
    private $payload;

    public function __construct(PheanstalkInterface $pheanstalk, array $payload = [])
    {
        $this->pheanstalk = $pheanstalk;
        $this->payload = $payload;
    }

    public function getPheanstalk(): PheanstalkInterface
    {
        return $this->pheanstalk;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public static function availableEvents(): array
    {
        return [
            self::BURY,
            self::DELETE,
            self::IGNORE,
            self::KICK,
            self::KICK_JOB,
            self::LIST_TUBE_USED,
            self::LIST_TUBES,
            self::LIST_TUBES_WATCHED,
            self::PAUSE_TUBE,
            self::RESUME_TUBE,
            self::PEEK,
            self::PEEK_READY,
            self::PEEK_DELAYED,
            self::PEEK_BURIED,
            self::PUT,
            self::RELEASE,
            self::RESERVE,
            self::RESERVE_WITH_TIMEOUT,
            self::STATS,
            self::STATS_TUBE,
            self::STATS_JOB,
            self::TOUCH,
            self::USE_TUBE,
            self::WATCH,
            self::WATCH_ONLY,
        ];
    }
}
