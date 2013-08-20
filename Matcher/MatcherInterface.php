<?php

namespace Success\InviteBundle\Matcher;

use Symfony\Component\HttpFoundation\Request;

interface MatcherInterface
{
    /**
     * Match referer
     *
     * @param  Request $request
     * @return RefererInterface
     */
    public function match(Request $request);
}