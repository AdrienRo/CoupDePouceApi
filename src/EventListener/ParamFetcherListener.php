<?php

namespace App\EventListener;

use App\Annotation\QueryParam;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\Request;

class ParamFetcherListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $reader = new AnnotationReader();
        $request = $event->getRequest();

        list($object, $name) = $event->getController();
        $method = new \ReflectionMethod($object, $name);
        $annotations = $reader->getMethodAnnotations($method);

        foreach($annotations as $annotation) {
            if ($annotation instanceof QueryParam) {
                $this->checkRequirement($request, $annotation);
            }
        }
    }

    private function checkRequirement(Request $request, QueryParam $queryParam)
    {
        $params = \array_merge($request->query->all(), $request->request->all());

        if (!\array_key_exists($queryParam->getName(), $params) && $queryParam->isRequired()) {
            throw new \App\Exception\CustomUserMessageException(
                $queryParam->getName().' attribute is missing'
            );
        }

        if (!\array_key_exists($queryParam->getName(), $params) && $queryParam->getDefault()) {
            $request->request->set($queryParam->getName(), $queryParam->getDefault());
        }
    }

}
