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
    protected function setServices(AbstractAdapter $Adapter)
    {
        $Adapter->setCldrDir($this->mockCldrDir());
        $Adapter->setLocaleService($this->mockLocaleService());
    }

    protected function mockCldrDir()
    {
        return 'Resources/cldr';
    }

    protected function mockLocaleService()
    {
        $LocaleService = $this
            ->getMockBuilder('\Agit\IntlBundle\Service\LocaleService')
            ->disableOriginalConstructor()
            ->getMock();

        $LocaleService->expects($this->any())
            ->method('getDefaultLocale')
            ->will($this->returnValue('en_GB'));

        $LocaleService->expects($this->any())
            ->method('getAvailableLocales')
            ->will($this->returnValue(['en_GB', 'de_DE']));

        return $LocaleService;
    }

    protected function mockCountryCurrencyAdapter()
    {
        $CountryCurrencyAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $CountryCurrencyAdapter->expects($this->any())
            ->method('getCountryCurrencyMap')
            ->will($this->returnValue(['BR' => 'BRL', 'CH' => 'CHE', 'DE' => 'EUR', 'GB' => 'GBP', 'US' => 'USD']));

        return $CountryCurrencyAdapter;
    }

    protected function mockCurrencyAdapter()
    {
        $CurrencyAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CurrencyAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $CurrencyList = [
            'BRL' => $this->mockCurrency('BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GBP' => $this->mockCurrency('GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'EUR' => $this->mockCurrency('EUR', 'Euro', 'Euro')
        ];

        $CurrencyAdapter->expects($this->any())
            ->method('getCurrencyList')
            ->will($this->returnValue($CurrencyList));

        $CurrencyAdapter->expects($this->any())
            ->method('getCurrency')
            ->will($this->returnCallback(function($code) use ($CurrencyList) {
                return $CurrencyList[$code];
            }));

        $CurrencyAdapter->expects($this->any())
            ->method('hasCurrency')
            ->will($this->returnCallback(function($code) use ($CurrencyList) {
                return isset($CurrencyList[$code]);
            }));

        return $CurrencyAdapter;
    }

    protected function mockCurrency($code, $nameEn, $nameDe)
    {
        $Currency = new Currency($code);
        $Currency->addName('en_GB', $nameEn);
        $Currency->addName('de_DE', $nameDe);
        return $Currency;
    }

    protected function mockCountryAdapter()
    {
        $CountryAdapter = $this
            ->getMockBuilder('\Agit\LocaleDataBundle\Adapter\CountryAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $CountryList = [
            'BR' => $this->mockCountry('BR', 'Brazil', 'Brasilien', 'BRL', 'Brazilian Real', 'Brasilianischer Real'),
            'GB' => $this->mockCountry('GB', 'United Kingdom', 'Vereinigtes Königreich', 'GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'),
            'DE' => $this->mockCountry('DE', 'Germany', 'Deutschland', 'EUR', 'Euro', 'Euro')
        ];

        $CountryAdapter->expects($this->any())
            ->method('getCountryList')
            ->will($this->returnValue($CountryList));

        $CountryAdapter->expects($this->any())
            ->method('getCountry')
            ->will($this->returnCallback(function($code) use ($CountryList) {
                return $CountryList[$code];
            }));

        $CountryAdapter->expects($this->any())
            ->method('hasCountry')
            ->will($this->returnCallback(function($code) use ($CountryList) {
                return isset($CountryList[$code]);
            }));

        return $CountryAdapter;
    }

    protected function mockCountry($code, $nameEn, $nameDe, $currCode, $currNameEn, $currNameDe)
    {
        $Country = new Country($code, $this->mockCurrency($currCode, $currNameEn, $currNameDe));
        $Country->addName('en_GB', $nameEn);
        $Country->addName('de_DE', $nameDe);
        return $Country;
    }
}