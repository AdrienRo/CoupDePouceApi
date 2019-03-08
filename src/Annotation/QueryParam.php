<?php

namespace App\Annotation;

use Symfony\Component\Validator\Constraints;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class QueryParam
{
    /** @Required */
    public $name;

    public $default;

    /** @Required */
    public $required;

    public function getName(): ?string
    {
        return (string) $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDefault(): ?string
    {
        return (string) $this->default;
    }

    public function setDefault(?string $default): self
    {
        $this->default = $default;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return (string) $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getConstraints()
    {
        $constraints = [];

        if ($this->required) {
            $constraints[] = new Constraints\NotNull();
        }
        return $constraints;
    }

}
