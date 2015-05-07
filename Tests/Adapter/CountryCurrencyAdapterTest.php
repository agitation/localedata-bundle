<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
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
        $CountryCurrencyAdapter = new CountryCurrencyAdapter();
        $CountryCurrencyAdapter->setCldrDir($this->mockCldrDir());
        $CountryCurrencyAdapter->setLocaleService($this->mockLocaleService());

        $map = $CountryCurrencyAdapter->getCountryCurrencyMap();

        $this->assertTrue(is_array($map));
        $this->assertArrayHasKey($countryCode, $map);
        $this->assertEquals($map[$countryCode], $currencyCode);
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



