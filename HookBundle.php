<?php

namespace ScyLabs\HookBundle;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HookBundle extends Bundle
{
    public function build(ContainerBuilder $container){
        parent::build($container);
    }
}