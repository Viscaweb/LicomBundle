<?php

namespace Visca\Bundle\LicomBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Visca\Bundle\LicomBundle\Services\Chain\OddsFormatterChain;

/**
 * Class OddsFormatterType
 */
class OddsFormatterType extends AbstractType
{
    const ODDS_FORMATTER_TRANSLATION_KEY = 'odds.formatter.%s';

    /**
     * @var OddsFormatterChain Chain of odds formatter
     */
    protected $oddsFormatterChain;

    /**
     * @var TranslatorInterface Translator
     */
    protected $translator;

    /**
     * OddsFormatterType constructor.
     *
     * @param OddsFormatterChain  $oddsFormatterChain Odds Formatter Chain
     * @param TranslatorInterface $translator         Translator
     */
    public function __construct(
        OddsFormatterChain $oddsFormatterChain,
        TranslatorInterface $translator
    ) {
        $this->oddsFormatterChain = $oddsFormatterChain;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'choices' => $this->getOddsFormattersChoices()
            ]
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'odds_formatter';
    }

    /**
     * Retrieve all the available odds formatter
     *
     * @return array
     */
    private function getOddsFormattersChoices()
    {
        $translator = $this->translator;

        $oddsFormatterChain = $this->oddsFormatterChain->all();
        $choices = [];
        foreach ($oddsFormatterChain as $oddsFormatterKey => $oddsFormatter) {
            $oddsFormatterLabelKey = sprintf(
                self::ODDS_FORMATTER_TRANSLATION_KEY,
                $oddsFormatterKey
            );
            $oddsFormatterLabel = $translator->trans($oddsFormatterLabelKey);
            $choices[$oddsFormatterKey] = $oddsFormatterLabel;
        }

        return $choices;
    }
}
