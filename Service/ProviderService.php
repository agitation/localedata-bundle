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
use Agit\LocaleDataBundle\Entity\LocaleRepository;
use Agit\LocaleDataBundle\Entity\TimezoneRepository;

/**
 * Facade service to all the intl repositories
 */
class ProviderService
{
    private $RepositoryList = [];

    public function __construct(
        CurrencyRepository $CurrencyRepository,
        CountryRepository $CountryRepository,
        LocaleRepository $LocaleRepository,
        TimezoneRepository $TimezoneRepository)
    {
        $this->RepositoryList['Currency'] = $CurrencyRepository;
        $this->RepositoryList['Country'] = $CountryRepository;
        $this->RepositoryList['Locale'] = $LocaleRepository;
        $this->RepositoryList['Timezone'] = $TimezoneRepository;
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

    public function getLocales(array $list = null)
    {
        return $this->getList('Locale', $list);
    }

    public function getLocale($id)
    {
        return $this->getOne('Locale', $id);
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
            ? $this->RepositoryList[$entityName]->findAll()
            : $this->RepositoryList[$entityName]->findBy(['id' => $list]);
    }

    private function getOne($entityName, $id)
    {
        return $this->RepositoryList[$entityName]->find($id);
    }
}
