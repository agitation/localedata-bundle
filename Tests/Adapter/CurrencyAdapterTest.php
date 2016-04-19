<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;

class CurrencyAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerCurrencies
     */
    public function testGetCurrencies($code, $nameEn, $nameDe)
    {
        $currencyAdapter = $this->createInstance();
        $currencies = $currencyAdapter->getCurrencies();

        $this->assertTrue(is_array($currencies));
        $this->assertArrayHasKey($code, $currencies);
        $this->assertEquals($code, $currencies[$code]->getCode());
        $this->assertEquals($nameEn, $currencies[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $currencies[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerCurrencies
     */
    public function testGetCurrency($code, $nameEn, $nameDe)
    {
        $currencyAdapter = $this->createInstance();
        $currency = $currencyAdapter->getCurrency($code);
        $this->assertTrue(is_object($currency));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Currency', get_class($currency));
        $this->assertEquals($nameEn, $currency->getName('en_GB'));
        $this->assertEquals($nameDe, $currency->getName('de_DE'));
    }

    public function createInstance()
    {
        $currencyAdapter = new CurrencyAdapter($this->mockCountryCurrencyAdapter());
        $currencyAdapter->setCldrDir($this->mockCldrDir());
        $currencyAdapter->setLocaleService($this->mockLocaleService());
        return $currencyAdapter;
    }

    public function providerCurrencies()
    {
        return [
            ['BRL', 'Brazilian Real', 'Brasilianischer Real'],
            ['EUR', 'Euro', 'Euro'],
            ['GBP', 'British Pound Sterling', 'Britisches Pfund Sterling'],
            ['USD', 'US Dollar', 'US-Dollar']
        ];
    }
}