<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 18/02/2020
 * Time: 12:06
 */

namespace ScyLabs\HookBundle;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HookBundle extends Bundle
{
    public function build(ContainerBuilder $container){
        parent::build($container);
    }
}