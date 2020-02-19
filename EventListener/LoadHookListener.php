<?php

namespace ScyLabs\HookBundle\EventListener;


use ScyLabs\GiftCodeBundle\Hook\EditAddressesHook;
use ScyLabs\GiftCodeBundle\Hook\ProfileBoxesHook;
use ScyLabs\HookBundle\Manager\HookManager;
use ScyLabs\HookBundle\Model\AbstractHook;
use ScyLabs\HookBundle\Model\HookInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class LoadHookListener
{
    private $container;
    private $hookManager;
    public function __construct(HookManager $hookManager,ContainerInterface $container) {
        $this->container = $container;
        $this->hookManager = $hookManager;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $bundles = require $projectDir.'/config/bundles.php';
        foreach ($bundles as $bundle => $env){
            if(!class_exists($bundle))
                continue;
            $reflectionObject = new \ReflectionClass($bundle);
            $bundleDir = dirname($reflectionObject->getFileName());
            if(!(file_exists($bundleDir.'/Hook') && is_dir($bundleDir.'/Hook')))
                continue;

            foreach (scandir($bundleDir.'/Hook') as $hookFile){
                if(!preg_match('/\.php$/Ui',$hookFile))
                    continue;

                $nameSpace = $reflectionObject->getNamespaceName();
                $nameSpace .= '\\Hook\\'.str_replace('.php','',$hookFile);


                if(class_exists($nameSpace) && $this->container->has($nameSpace) && $this->container->get($nameSpace) instanceof AbstractHook)
                    $this->hookManager->addHook($this->container->get($nameSpace));

            }

        }
        if(file_exists($projectDir.'/composer.json')){
            if (null !== $composerJson = json_decode(file_get_contents($projectDir.'/composer.json'))){

                $projectNameSpaceConfig = ((array)$composerJson->autoload)['psr-4'];
                $projectNameSpace = null;
                $sourcesDir = null;
                foreach ($projectNameSpaceConfig as $nameSpace => $directory){
                    $projectNameSpace = trim($nameSpace,'\\');
                    $sourcesDir = $projectDir.'/'.trim($directory,'\\');
                }

                if(file_exists($sourcesDir.'/Hook') && is_dir($sourcesDir.'/Hook')){
                    foreach (scandir($sourcesDir.'/Hook') as $hookFile){
                        if(!preg_match('/\.php$/Ui',$hookFile))
                            continue;

                        $nameSpace = $projectNameSpace;
                        $nameSpace .= '\\Hook\\'.str_replace('.php','',$hookFile);

                        if(class_exists($nameSpace) && $this->container->has($nameSpace) && $this->container->get($nameSpace) instanceof AbstractHook)
                            $this->hookManager->addHook($this->container->get($nameSpace));

                    }
                }

            }

        }

    }

    private function getParameter(string $parameter){
        return $this->container->getParameter($parameter);
    }
}