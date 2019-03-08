<?php 

namespace App\EventListener;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\Exception;

class ExceptionListener
{
	public function onKernelException(GetResponseForExceptionEvent $event)
	{
		$exception = $event->getException();
		$content = ['message' => $exception->getMessage()];

		if (method_exists($exception, 'getErrors') && $exception->getErrors()) {
			$content['errors'] = $exception->getErrors();
		}

		$response = new JsonResponse($content);

		if ($exception instanceof HttpExceptionInterface) {
			$response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
		} else if ($event->getException()->getCode() > 0) {
			$response->setStatusCode($event->getException()->getCode());
		}

		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');

		$event->setResponse($response);
	}

}
