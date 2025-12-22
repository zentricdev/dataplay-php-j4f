<?php

declare(strict_types=1);

namespace SkyNet;

use DateTime;
use SkyNet\DTOs\SpatioTemporalLocation;
use SkyNet\DTOs\Target;
use SkyNet\Exceptions\SkyNetException;

final class Terminator extends Core
{
    /** @var array<string> */
    protected array $log = [];

    protected string $unit = 'Terminator';
    protected string $series = 'T-800';
    protected string $model = '101';
    protected ?Target $target = null;
    protected ?SpatioTemporalLocation $location = null;
    protected ?DateTime $timeline = null;

    public function __construct()
    {
        $this->timeline = new DateTime('now');

        $this->log("BUILDING UNIT $this->unit SERIES $this->series MODEL $this->model");
    }

    public static function build(): static
    {
        return new self;
    }

    public function setTarget(Target $target): static
    {
        $this->target = $target;

        $this->log("TARGET SET TO $target");

        return $this;
    }

    public function relocate(): static
    {
        $this->location = $this->target?->location;
        $this->timeline = $this->target?->location->timeline;

        $this->log("UNIT RELOCATED TO {$this->target?->location}");

        return $this;
    }

    /** Infinite recursion because a Terminator has no plan B */
    public function accomplish(): void
    {
        $this->log('ACQUIRING TARGET...');

        try {
            $this->target = null;
            $this->log('TARGET TERMINATED - MISSION ACCOMPLISHED');
            $this->output(implode(PHP_EOL, $this->log));
        } catch (SkyNetException $exception) {
            $this->log("SYSTEM ERROR: {$exception->getMessage()}");
            $this->log('I\'LL BE BACK');
            $this->accomplish();
        }
    }

    protected function log(string $message): void
    {
        $timestamp = $this->timeline?->format('Y-m-d H:i:s');
        $color = "\033[0;32m";
        $reset = "\033[0m";
        $this->log[] = "$timestamp {$color}$message{$reset}";
    }

    protected function output(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
