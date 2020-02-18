<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22/11/2019
 * Time: 12:05
 */

namespace ScyLabs\HookBundle\DataCollector;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class HookCollector extends DataCollector
{


    /**
     * Collects data for the given Request and Response.
     *
     * @param \Throwable|null $exception
     */
    public function collect(Request $request, Response $response,?\Throwable $exception = null) {
        $data = $request->getSession()->get('scy_labs_hooks');

        if(null === $data || !is_array($data)){
            $this->data = [];
        }else{
            $this->data = $data;
        }

        $request->getSession()->remove('scy_labs_hooks');


    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName() {
        return 'scy_labs_hooks';
    }

    public function reset() {
        $this->data = [];
    }
    public function count(){
        return sizeof($this->data);
    }
    public function getHooks(){
        return $this->data;
    }
    public function countLinks(){
        $count = 0;
        foreach ($this->data as $data){
            $count += sizeof($data['links']);
        }
        return $count;
    }

}