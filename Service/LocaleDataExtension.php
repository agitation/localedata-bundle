<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Collator;
use Twig_Extension;
use Twig_Function_Method;
use Agit\IntlBundle\Service\LocaleService;

class LocaleDataExtension extends Twig_Extension
{
    private $providerService;

    private $localeService;

    public function __construct(ProviderService $providerService, LocaleService $localeService)
    {
        $this->providerService = $providerService;
        $this->localeService = $localeService;
    }

    public function getFunctions()
    {
        return [
            "getCountries"  => new Twig_Function_Method($this, "getCountries"),
            "getCurrencies" => new Twig_Function_Method($this, "getCurrencies"),
            "getLanguages"  => new Twig_Function_Method($this, "getLanguages"),
            "getTimezones"  => new Twig_Function_Method($this, "getTimezones")
        ];
    }

    public function getName()
    {
        return "agit.localedata";
    }

    public function getCountries(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getCurrencies(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getLanguages(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getTimezones(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    private function getList($method, array $list = null)
    {
        $results = [];

        foreach ($this->providerService->$method($list) as $entity) {
            $results[$entity->getId()] = $entity->getName();
        }

        if (class_exists("Collator")) {
            $collator = new Collator($this->localeService->getLocale());
            uasort($results, [$collator, "compare"]);
        }

        return $results;
    }
}
