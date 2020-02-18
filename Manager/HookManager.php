<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/11/2019
 * Time: 13:34
 */

namespace ScyLabs\HookBundle\Manager;


use Doctrine\Common\Collections\ArrayCollection;
use ScyLabs\HookBundle\Model\HookInterface;

class HookManager
{
    private $hooks = [];

    public function getHooks(string  $hookName){
        return (array_key_exists($hookName,$this->hooks)) ? $this->hooks[$hookName] : [];
    }
    public function addHook(HookInterface $hook){
        foreach ($hook->getNames() as $hookName){
            if(!array_key_exists($hookName,$this->hooks))
                $this->hooks[$hookName] = [];

            if(!array_key_exists($hook->getPriority(),$this->hooks[$hookName]))
                $this->hooks[$hookName][$hook->getPriority()] = [];

            $this->hooks[$hookName][$hook->getPriority()][] = $hook;
            ksort($this->hooks[$hookName]);
        }
    }
}