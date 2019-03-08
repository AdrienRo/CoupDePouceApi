<?php

namespace App\Model;

use App\Entity\Offer;
use Symfony\Component\Validator\Constraints as Assert;

class Simulation
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $department;

    /**
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $income;

    /**
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     * @Assert\GreaterThan(0)
     */
    private $amount;

    /**
     * @Assert\NotBlank
     * @Assert\Type("numeric")
     * @Assert\GreaterThan(0)
     */
    private $household;

    public function getDepartment(): ?string
    {
        return (string) $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @Assert\IsTrue(message="The department is invalid")
     */
    public function isDepartmentValid(): bool
    {
        $departments = [];

        for ($ten = 0; $ten <= 9; $ten++) {
            for ($unit = 0; $unit <= 9; $unit++) {
                if ($ten === 9 && $unit > 5) {
                    continue;
                }
                $departments[] = strval($ten).strval($unit);
            }
        }

        return \in_array($this->department, $departments);
    }

    public function getIncome(): ?string
    {
        return (string) $this->income;
    }

    public function setIncome(string $income): self
    {
        $this->income = $income;

        return $this;
    }

    public function getAmount(): ?string
    {
        return (string) $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getHousehold(): ?string
    {
        return (string) $this->household;
    }

    public function setHousehold(string $household): self
    {
        $this->household = $household;

        return $this;
    }

    public function getCategory(): string
    {
        if (\in_array($this->department, ['75','77','78','91','92','93','94','95'])) {
			switch ($this->household) {
				case 1:
					if ($this->income <= 24194) {
                        return 'Modeste';
                        break;
					} 

				case 2:
                    if ($this->income <= 35510) {
                        return 'Modeste';
                        break;
                    }

				case 3:
					if ($this->income <= 42648) {
                        return 'Modeste';
                        break;
                    }

				case 4:
					if ($this->income <= 49799) {
                        return 'Modeste';
                        break;
                    }
				
				case 5:
					if ($this->income <= 56970) {
                        return 'Modeste';
                        break;
                    }
				
				default:
					if ($this->income <= 56970 + ($this->household - 5) * 7162) {
						return 'Modeste';
                        break;
                    }
                    return 'Autre';
			}
		} else {
            switch ($this->household) {
			    case 1:
					if ($this->income <= 18409) {
                        return 'Modeste';
                        break;
					} 

				case 2:
                    if ($this->income <= 26923) {
                        return 'Modeste';
                        break;
                    }

				case 3:
					if ($this->income <= 32377) {
                        return 'Modeste';
                        break;
                    }

				case 4:
					if ($this->income <= 37826) {
                        return 'Modeste';
                        break;
                    }
				
				case 5:
					if ($this->income <= 43297) {
                        return 'Modeste';
                        break;
                    }
				
				default:
					if ($this->income <= 43297 + ($this->household - 5) * 5454) {
						return 'Modeste';
                        break;
                    }
                    return 'Autre';
            }
		}
    }

    public function getFilteredAmount(Offer $offer)
    {
        foreach($offer->getAmounts() as $amount) {
            if ($amount->getRessourceCat() === $this->getCategory()) {
                return $amount;
            }
        }
        return;
    }

    public function getResults(Offer $offer)
    {
        $amount = $this->getFilteredAmount($offer);

        if ($amount) {
            return $amount->getValue() * $this->amount;
        }
        return;
    }

}
