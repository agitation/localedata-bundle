<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 *
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
    public function testGetCountries($code, $nameEn, $nameDe)
    {
        $countryAdapter = $this->createInstance();
        $countries = $countryAdapter->getCountries();

        $this->assertTrue(is_array($countries));
        $this->assertArrayHasKey($code, $countries);
        $this->assertSame($code, $countries[$code]->getCode());
        $this->assertSame($nameEn, $countries[$code]->getName('en_GB'));
        $this->assertSame($nameDe, $countries[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerCountries
     */
    public function testGetCountry($code, $nameEn, $nameDe)
    {
        $countryAdapter = $this->createInstance();
        $country = $countryAdapter->getCountry($code);
        $this->assertTrue(is_object($country));
        $this->assertSame('Agit\LocaleDataBundle\Adapter\Object\Country', get_class($country));
        $this->assertSame($nameEn, $country->getName('en_GB'));
        $this->assertSame($nameDe, $country->getName('de_DE'));
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
