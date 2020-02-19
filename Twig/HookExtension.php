<?php

namespace ScyLabs\HookBundle\Twig;


use ScyLabs\HookBundle\Model\HooksFounderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;



class HookExtension extends AbstractExtension
{

    private $hooksFounder;
    public function __construct(HooksFounderInterface $hooksFounder) {
        $this->hooksFounder = $hooksFounder;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('ScyLabs_showHook',array($this,'showHook')),
            new TwigFunction('showHook',[$this,'showHook'])
        );
    }

    public function showHook(string $template,string $hookName){

        $hooksByPriority = $this->hooksFounder->getHooks($template,$hookName);

        $render = [];

        foreach ($hooksByPriority as $hooks){
            foreach ($hooks as $hook){
                $render[] = $hook->showHook();
            }
        }
        return implode('',$render);

    }
}