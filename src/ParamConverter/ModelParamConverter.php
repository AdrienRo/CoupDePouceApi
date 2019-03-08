<?php

namespace App\ParamConverter;

use App\Exception\CustomUserMessageException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ModelParamConverter implements ParamConverterInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $model = new $class();
        $errors = [];

        $this->hydrateModelFromRequest($model, $request);

        foreach ($this->validator->validate($model) as $error) {
            $errors[] = [
                'property' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }

        if ($errors) {
            throw new CustomUserMessageException('Bad request', $errors, 400);
        }

        $paths = \explode('\\', $class);
        $request->attributes->set(\strtolower(\array_pop($paths)), $model);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getConverter() === 'model';
    }

    private function hydrateModelFromRequest(object $model, Request $request): object
    {
        $data = array_merge($request->query->all(), $request->request->all());
        $class = new \ReflectionClass($model);

       foreach($data as $key => $value) {
            $setter = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if ($class->hasMethod($setter) && $class->getMethod($setter)->isPublic()) {
                $method = $class->getMethod($setter);
                $parameter = $method->getParameters()[0];

                if ($class->getMethod($setter)->getNumberOfRequiredParameters() === 1) {
                    if ($parameter->getType()->getName() === gettype($value)) {
                        $model->$setter($value);
                    }
                }
            }
        }
        return $model;
    }
}
