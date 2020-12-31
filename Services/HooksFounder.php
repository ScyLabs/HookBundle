<?php

namespace ScyLabs\HookBundle\Services;


use ScyLabs\HookBundle\Manager\HookManager;
use ScyLabs\HookBundle\Model\HooksFounderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HooksFounder implements HooksFounderInterface,ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getHooks(string $template,string $hookName) : array{

        $session = $this->container->get('session');
        $manager = $this->container->get(HookManager::class);

        $hooksByPriority = $manager->getHooks($hookName);
        ksort($hooksByPriority);

        if($this->container->has('profiler')){
            $sessionHooks = $session->get('scy_labs_hooks');
            $hooksLinks = [];
            foreach ($hooksByPriority as $prio){
                foreach ($prio as $hook){
                    $hooksLinks[] = get_class($hook);
                }
            }
            if(null === $sessionHooks || !is_array($sessionHooks)){
                $session->set('scy_labs_hooks',[
                    $hookName    =>  [
                        "template"      =>  $template,
                        "links"         => $hooksLinks
                    ]
                ]);
            }else{

                $session->set('scy_labs_hooks',array_merge([$hookName    => [
                    'template'   =>  $template,
                    'links' =>  $hooksLinks
                ]],$sessionHooks));
            }

        }

        return $hooksByPriority;

    }
}