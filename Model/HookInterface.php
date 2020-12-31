<?php

namespace ScyLabs\HookBundle\Model;


interface HookInterface
{
    public function getNames() : array;
    public function getPriority() : int;
    public function showHook();

}