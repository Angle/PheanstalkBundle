<?php

namespace Angle\PheanstalkBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait DataCollectorBCTrait
{
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->doCollect($request, $response, $exception);
    }

    protected abstract function doCollect(Request $request, Response $response, \Throwable $exception = null);
}

