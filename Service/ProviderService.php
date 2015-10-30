<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Agit\LocaleDataBundle\Entity\CountryRepository;
use Agit\LocaleDataBundle\Entity\CurrencyRepository;
use Agit\LocaleDataBundle\Entity\LanguageRepository;
use Agit\LocaleDataBundle\Entity\TimezoneRepository;

/**
 * Facade service to all the intl repositories
 */
class ProviderService
{
    private $repositoryList = [];

    public function __construct(
        CurrencyRepository $currencyRepository,
        CountryRepository $countryRepository,
        LanguageRepository $languageRepository,
        TimezoneRepository $timezoneRepository)
    {
        $this->repositoryList['Currency'] = $currencyRepository;
        $this->repositoryList['Country'] = $countryRepository;
        $this->repositoryList['Language'] = $languageRepository;
        $this->repositoryList['Timezone'] = $timezoneRepository;
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
            ? $this->repositoryList[$entityName]->findAll()
            : $this->repositoryList[$entityName]->findBy(['id' => $list]);
    }

    private function getOne($entityName, $id)
    {
        return $this->repositoryList[$entityName]->find($id);
    }
}
