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
        $CountryAdapter = $this->createInstance();
        $CountryList = $CountryAdapter->getCountryList();

        $this->assertTrue(is_array($CountryList));
        $this->assertArrayHasKey($code, $CountryList);
        $this->assertEquals($code, $CountryList[$code]->getCode());
        $this->assertEquals($nameEn, $CountryList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $CountryList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerCountries
     */
    public function testGetCountry($code, $nameEn, $nameDe)
    {
        $CountryAdapter = $this->createInstance();
        $Country = $CountryAdapter->getCountry($code);
        $this->assertTrue(is_object($Country));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Country', get_class($Country));
        $this->assertEquals($nameEn, $Country->getName('en_GB'));
        $this->assertEquals($nameDe, $Country->getName('de_DE'));
    }

    public function createInstance()
    {
        $CountryAdapter = new CountryAdapter($this->mockCurrencyAdapter(), $this->mockCountryCurrencyAdapter());
        $CountryAdapter->setCldrDir($this->mockCldrDir());
        $CountryAdapter->setLocaleService($this->mockLocaleService());
        return $CountryAdapter;
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