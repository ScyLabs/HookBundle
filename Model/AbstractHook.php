<?php

namespace ScyLabs\HookBundle\Model;


use ScyLabs\HookBundle\Model\HookInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractHook implements HookInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    private $templating;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->templating = $container->get('twig');
    }
    protected function render(string $template,array $options = []){
        return $this->templating->render($template,$options);
    }

}