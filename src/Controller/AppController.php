<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Model\Simulation;
use App\Annotation\QueryParam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class AppController extends AbstractController
{
    /**
     * @Route("/simulation/{name}", name="simulation", methods={"GET"})
     * @QueryParam(name = "department", required = true)
     * @QueryParam(name = "income", required = true)
     * @QueryParam(name = "amount", default = 1)
     * @QueryParam(name = "household", required = true)
     * @ParamConverter("simulation", class="\App\Model\Simulation", converter="model")
     * @Entity("offer", expr="repository.findOneByName(name)")
     */
    public function simulate(Simulation $simulation, Offer $offer)
    {
        return $this->json([
            'offre' => $offer->getName(),
            'category' => $simulation->getCategory(),
            'amount' => $simulation->getResults($offer)
        ]);
    }

}
