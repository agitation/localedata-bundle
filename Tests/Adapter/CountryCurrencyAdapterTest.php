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

use Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter;

class CountryCurrencyAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerGetCountryCurrencyMap
     */
    public function testGetCountryCurrencyMap($countryCode, $currencyCode)
    {
        $countryCurrencyAdapter = new CountryCurrencyAdapter();
        $countryCurrencyAdapter->setCldrDir($this->mockCldrDir());
        $countryCurrencyAdapter->setLocaleService($this->mockLocaleService());

        $map = $countryCurrencyAdapter->getCountryCurrencyMap();

        $this->assertTrue(is_array($map));
        $this->assertArrayHasKey($countryCode, $map);
        $this->assertSame($map[$countryCode], $currencyCode);
    }

    public function providerGetCountryCurrencyMap()
    {
        return [
            ['AU', 'AUD'],
            ['BR', 'BRL'],
            ['CH', 'CHF'],
            ['DE', 'EUR'],
            ['GB', 'GBP'],
            ['US', 'USD'],
            ['ZA', 'ZAR']
        ];
    }
}
