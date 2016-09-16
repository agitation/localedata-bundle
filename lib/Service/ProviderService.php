<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Agit\LocaleDataBundle\Entity\CountryRepository;
use Agit\LocaleDataBundle\Entity\CurrencyRepository;
use Agit\LocaleDataBundle\Entity\LanguageRepository;
use Agit\LocaleDataBundle\Entity\TimezoneRepository;

/**
 * Facade service to all the intl repositories.
 */
class ProviderService
{
    private $repositories = [];

    public function __construct(
        CurrencyRepository $currencyRepository,
        CountryRepository $countryRepository,
        LanguageRepository $languageRepository,
        TimezoneRepository $timezoneRepository)
    {
        $this->repositories['Currency'] = $currencyRepository;
        $this->repositories['Country'] = $countryRepository;
        $this->repositories['Language'] = $languageRepository;
        $this->repositories['Timezone'] = $timezoneRepository;
    }

    public function getCountries(array $list = null)
    {
        return $this->getList('Country', $list);
    }

    public function getCountry($id)
    {
        return $this->getOne('Country', $id);
    }

    public function getCurrencies(array $list = null)
    {
        return $this->getList('Currency', $list);
    }

    public function getCurrency($id)
    {
        return $this->getOne('Currency', $id);
    }

    public function getLanguages(array $list = null)
    {
        return $this->getList('Language', $list);
    }

    public function getLanguage($id)
    {
        return $this->getOne('Language', $id);
    }

    public function getTimezones(array $list = null)
    {
        return $this->getList('Timezone', $list);
    }

    public function getTimezone($id)
    {
        return $this->getOne('Timezone', $id);
    }

    private function getList($entityName, array $list = null)
    {
        return ($list === null)
            ? $this->repositories[$entityName]->findAll()
            : $this->repositories[$entityName]->findBy(['id' => $list]);
    }

    private function getOne($entityName, $id)
    {
        return $this->repositories[$entityName]->find($id);
    }
}
