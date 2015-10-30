<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\CountryAdapter;

class CountryAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerCountries
     */
    public function testGetCountryList($code, $nameEn, $nameDe)
    {
        $countryAdapter = $this->createInstance();
        $countryList = $countryAdapter->getCountryList();

        $this->assertTrue(is_array($countryList));
        $this->assertArrayHasKey($code, $countryList);
        $this->assertEquals($code, $countryList[$code]->getCode());
        $this->assertEquals($nameEn, $countryList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $countryList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerCountries
     */
    public function testGetCountry($code, $nameEn, $nameDe)
    {
        $countryAdapter = $this->createInstance();
        $country = $countryAdapter->getCountry($code);
        $this->assertTrue(is_object($country));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Country', get_class($country));
        $this->assertEquals($nameEn, $country->getName('en_GB'));
        $this->assertEquals($nameDe, $country->getName('de_DE'));
    }

    public function createInstance()
    {
        $countryAdapter = new CountryAdapter($this->mockCurrencyAdapter(), $this->mockCountryCurrencyAdapter());
        $countryAdapter->setCldrDir($this->mockCldrDir());
        $countryAdapter->setLocaleService($this->mockLocaleService());
        return $countryAdapter;
    }

    public function providerCountries()
    {
        return [
            ['BR', 'Brazil', 'Brasilien'],
            ['DE', 'Germany', 'Deutschland'],
            ['GB', 'United Kingdom', 'Vereinigtes Königreich']
        ];
    }
}