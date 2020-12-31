<?php

namespace ScyLabs\HookBundle\Model;


interface HooksFounderInterface
{
    public function getHooks(string $template,string $hookName) : array;
}