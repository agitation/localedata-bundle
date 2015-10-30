<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\AbstractAdapter;
use Agit\LocaleDataBundle\Adapter\Object\Currency;
use Agit\LocaleDataBundle\Adapter\Object\Country;

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

        $currencyList = [
            'BRL' => $this->mockCurrency('BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GBP' => $this->mockCurrency('GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'EUR' => $this->mockCurrency('EUR', 'Euro', 'Euro')
        ];

        $currencyAdapter->expects($this->any())
            ->method('getCurrencyList')
            ->will($this->returnValue($currencyList));

        $currencyAdapter->expects($this->any())
            ->method('getCurrency')
            ->will($this->returnCallback(function($code) use ($currencyList) {
                return $currencyList[$code];
            }));

        $currencyAdapter->expects($this->any())
            ->method('hasCurrency')
            ->will($this->returnCallback(function($code) use ($currencyList) {
                return isset($currencyList[$code]);
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

        $countryList = [
            'BR' => $this->mockCountry('BR', 'Brazil', 'Brasilien', 'BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GB' => $this->mockCountry('GB', 'United Kingdom', 'Vereinigtes Königreich', 'GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'DE' => $this->mockCountry('DE', 'Germany', 'Deutschland', 'EUR', 'Euro', 'Euro')
        ];

        $countryAdapter->expects($this->any())
            ->method('getCountryList')
            ->will($this->returnValue($countryList));

        $countryAdapter->expects($this->any())
            ->method('getCountry')
            ->will($this->returnCallback(function($code) use ($countryList) {
                return $countryList[$code];
            }));

        $countryAdapter->expects($this->any())
            ->method('hasCountry')
            ->will($this->returnCallback(function($code) use ($countryList) {
                return isset($countryList[$code]);
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