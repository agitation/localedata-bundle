<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\AbstractAdapter;
use Agit\LocaleDataBundle\Adapter\Object\Country;
use Agit\LocaleDataBundle\Adapter\Object\Currency;

// NOTE: this is not a test for the AbstractAdapter, but a helper for adapter tests
abstract class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{
    // set the common services for all adapters
    protected function setServices(AbstractAdapter $adapter)
    {
        $adapter->setCldrDir($this->mockCldrDir());
        $adapter->setLocaleService($this->mockLocaleService());
    }

    protected function mockCldrDir()
    {
        return 'Resources/cldr';
    }

    protected function mockLocaleService()
    {
        $localeService = $this
            ->getMockBuilder('\Agit\IntlBundle\Service\LocaleService')
            ->disableOriginalConstructor()
            ->getMock();

        $localeService->expects($this->any())
            ->method('getDefaultLocale')
            ->will($this->returnValue('en_GB'));

        $localeService->expects($this->any())
            ->method('getAvailableLocales')
            ->will($this->returnValue(['en_GB', 'de_DE']));

        return $localeService;
    }

    protected function mockCountryCurrencyAdapter()
    {
        $countryCurrencyAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $countryCurrencyAdapter->expects($this->any())
            ->method('getCountryCurrencyMap')
            ->will($this->returnValue(['BR' => 'BRL', 'CH' => 'CHE', 'DE' => 'EUR', 'GB' => 'GBP', 'US' => 'USD']));

        return $countryCurrencyAdapter;
    }

    protected function mockCurrencyAdapter()
    {
        $currencyAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CurrencyAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $currencies = [
            'BRL' => $this->mockCurrency('BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GBP' => $this->mockCurrency('GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'EUR' => $this->mockCurrency('EUR', 'Euro', 'Euro')
        ];

        $currencyAdapter->expects($this->any())
            ->method('getCurrencies')
            ->will($this->returnValue($currencies));

        $currencyAdapter->expects($this->any())
            ->method('getCurrency')
            ->will($this->returnCallback(function ($code) use ($currencies) {
                return $currencies[$code];
            }));

        $currencyAdapter->expects($this->any())
            ->method('hasCurrency')
            ->will($this->returnCallback(function ($code) use ($currencies) {
                return isset($currencies[$code]);
            }));

        return $currencyAdapter;
    }

    protected function mockCurrency($code, $nameEn, $nameDe)
    {
        $currency = new Currency($code);
        $currency->addName('en_GB', $nameEn);
        $currency->addName('de_DE', $nameDe);

        return $currency;
    }

    protected function mockCountryAdapter()
    {
        $countryAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CountryAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $countries = [
            'BR' => $this->mockCountry('BR', 'Brazil', 'Brasilien', 'BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GB' => $this->mockCountry('GB', 'United Kingdom', 'Vereinigtes Königreich', 'GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'DE' => $this->mockCountry('DE', 'Germany', 'Deutschland', 'EUR', 'Euro', 'Euro')
        ];

        $countryAdapter->expects($this->any())
            ->method('getCountries')
            ->will($this->returnValue($countries));

        $countryAdapter->expects($this->any())
            ->method('getCountry')
            ->will($this->returnCallback(function ($code) use ($countries) {
                return $countries[$code];
            }));

        $countryAdapter->expects($this->any())
            ->method('hasCountry')
            ->will($this->returnCallback(function ($code) use ($countries) {
                return isset($countries[$code]);
            }));

        return $countryAdapter;
    }

    protected function mockCountry($code, $nameEn, $nameDe, $currCode, $currNameEn, $currNameDe)
    {
        $country = new Country($code, $this->mockCurrency($currCode, $currNameEn, $currNameDe));
        $country->addName('en_GB', $nameEn);
        $country->addName('de_DE', $nameDe);

        return $country;
    }
}
