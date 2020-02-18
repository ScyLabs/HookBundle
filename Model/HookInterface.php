<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22/11/2019
 * Time: 09:14
 */

namespace ScyLabs\HookBundle\Model;


interface HookInterface
{
    public function getNames() : array;
    public function getPriority() : int;
    public function showHook();

}