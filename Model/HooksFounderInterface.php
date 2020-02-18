<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 18/02/2020
 * Time: 15:07
 */

namespace ScyLabs\HookBundle\Model;


interface HooksFounderInterface
{
    public function getHooks(string $template,string $hookName) : array;
}