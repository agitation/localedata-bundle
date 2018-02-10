<?php
declare(strict_types=1);
/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Annotation\Controller\Controller;
use Agit\ApiBundle\Annotation\Depends;
use Agit\ApiBundle\Annotation\Endpoint;
use Agit\ApiBundle\Api\Controller\AbstractController;
use Agit\IntlBundle\Service\LocaleService;
use Doctrine\ORM\EntityManager;

/**
 * @Controller(namespace="common.v1")
 * @Depends({"@agit.intl.locale", "@doctrine.orm.entity_manager"})
 */
class Locale extends AbstractController
{
    private $entityManager;

    private $localeService;

    public function __construct(LocaleService $localeService, EntityManager $entityManager)
    {
        $this->localeService = $localeService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Endpoint\Endpoint(request="common.v1/ScalarNull", response="Locale[]")
     * @Endpoint\Security(capability="")
     * @Endpoint\CrossOrigin(allow="all")
     */
    public function search()
    {
        $locales = $this->localeService->getAvailableLocales();
        $langs = array_map(function ($locale) {
            return substr($locale, 0, 2);
        }, $locales);

        $languages = $this->entityManager->createQueryBuilder()
            ->select('language')
            ->from('AgitLocaleDataBundle:Language', 'language', 'language.id')
            ->where('language.id IN (:langs)')
            ->setParameter('langs', $langs)
            ->getQuery()->getResult();

        $result = [];

        foreach ($locales as $locale)
        {
            list($lang, $countryCode) = explode('_', $locale);
            $result[] = $this->createLocaleObject($locale, $languages[$lang], $countryCode);
        }

        return $result;
    }

    private function createLocaleObject($localeCode, $language, $countryCode)
    {
        $locale = $this->createObject('Locale');
        $locale->set('id', $localeCode);
        $locale->set('name', sprintf('%s (%s)', $language->getName(), $countryCode));

        return $locale;
    }
}
