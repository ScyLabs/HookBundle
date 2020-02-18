<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22/11/2019
 * Time: 09:32
 */

namespace ScyLabs\HookBundle\Model;


use ScyLabs\HookBundle\Model\HookInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractHook implements HookInterface
{
    private $container;
    private $templating;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->templating = $container->get('twig');
    }
    protected function render(string $template,array $options = []){
        return $this->templating->render($template,$options);
    }

}