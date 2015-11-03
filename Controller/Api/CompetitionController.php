<?php

namespace Visca\Bundle\LicomBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Visca\Bundle\CoreBundle\Controller\Api\Abstracts\ApiController;
use Visca\Bundle\LicomBundle\Entity\Competition;

/**
 * Class CompetitionController.
 *
 * @Route("/competitions", options={"expose"=true})
 */
class CompetitionController extends ApiController
{
    /**
     * @param int $id
     *
     * @return Competition[]
     *
     * @Route("/category/{id}.{_format}", name="api_1_get_competition_from_category")
     *
     * @Method({"GET"})
     *
     * @ApiDoc(
     *  resource = true,
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="category id"}
     *  },
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the competition is invalid"
     *  }
     * )
     */
    public function getCompetitionFromCompetitionCategoryAction($id)
    {
        $competition = $this
            ->get('visca_licom.repository.competition')
            ->findOneById(1);
        $competitions = [$competition, $competition, $competition];

        return $competitions;
    }
}
