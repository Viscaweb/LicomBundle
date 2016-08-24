<?php

namespace Visca\Bundle\LicomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;

/**
 * Class DebugSlugCountryController.
 */
class DebugSlugCountryController extends Controller
{
    /**
     * @return Response
     */
    public function testSlugMatchersAction()
    {
        $e = $this->get('visca_licom.matcher.participant_combination');
        list($f1) = $e->getParticipantCombinations('barcelona-real-madrid');
        list($f2) = $e->getParticipantCombinations('barcelona-espanyol');
        list($f3) = $e->getParticipantCombinations('espanyol-barcelona');
        $v = 1;
        /*
         * Prepare the objects
         */
        if ($this->container->getParameter('licom_profile_id') != 5) {
            $html =
                '<h3>To launch this <u>debug</u> controller, please switch your '.
                'parameters.yml to use the <u>licom_profile_id</u> to 5 (marcadores.com)'.
                '<br/>Indeed, the matcher is using the translations related to the Profiles '.
                'and the Localizations related.';

            return new Response($html);
        }

        /*
         * Finding initial data
         */
        /** @var Sport $sportSoccer */
        $sportSoccer = $this->get('visca_licom.repository.sport')->findOneBy(
            ['id' => 1]
        );

        /*
         * Finding the Country "italy"
         */
        $slugItaly = 'italia';
        $html =
            sprintf(
                'Using the translations of Marcadores.com (licom_profile_id = 5), '.
                'we know that the matchers should find a Country using the '.
                'following slug: "%s".<br/><hr/>',
                $slugItaly
            );

        $countrySlugMatcher = $this->get('visca_licom.matcher.slug.country');
        $html .= sprintf('<h3>Slug: %s</h3>', $slugItaly);
        try {
            $country = $countrySlugMatcher->match($slugItaly, $sportSoccer);
            $html .= sprintf(
                'A country has been found with the following values:<br/>'.
                'ID = %d<br/>'.
                'Name = %s<hr/>',
                $country->getId(),
                $country->getName()
            );
        } catch (NoMatchFoundException $ex) {
            $html .= 'Unable to find this country, NoMatchFoundException thrown.<br/>';
        }

        /*
         * Trying to get an exception
         */
        $fakeSlugItaly = $slugItaly.'-does-not-exists';
        $html .= sprintf('<h3>Slug: %s</h3>', $fakeSlugItaly);
        $html .=
            sprintf(
                'Now, let\'s try with a slug that DOES NOT exists ("%s").<br/>',
                $fakeSlugItaly
            );

        try {
            $country = $countrySlugMatcher->match($fakeSlugItaly, $sportSoccer);
            $html .= sprintf(
                'A country has been found with the following values:<br/>'.
                'ID = %d<br/>'.
                'Name = %s<br/><br/>',
                $country->getId(),
                $country->getName()
            );
        } catch (NoMatchFoundException $ex) {
            $html .= 'Unable to find this country, NoMatchFoundException thrown.<br/>';
        }

        $html .= '</pre>';

        return new Response($html);
    }
}
