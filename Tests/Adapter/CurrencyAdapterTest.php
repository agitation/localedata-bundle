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
    public function testGetCurrencyList($code, $nameEn, $nameDe)
    {
        $CurrencyAdapter = $this->createInstance();
        $CurrencyList = $CurrencyAdapter->getCurrencyList();

        $this->assertTrue(is_array($CurrencyList));
        $this->assertArrayHasKey($code, $CurrencyList);
        $this->assertEquals($code, $CurrencyList[$code]->getCode());
        $this->assertEquals($nameEn, $CurrencyList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $CurrencyList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerCurrencies
     */
    public function testGetCurrency($code, $nameEn, $nameDe)
    {
        $CurrencyAdapter = $this->createInstance();
        $Currency = $CurrencyAdapter->getCurrency($code);
        $this->assertTrue(is_object($Currency));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Currency', get_class($Currency));
        $this->assertEquals($nameEn, $Currency->getName('en_GB'));
        $this->assertEquals($nameDe, $Currency->getName('de_DE'));
    }

    public function createInstance()
    {
        $CurrencyAdapter = new CurrencyAdapter($this->mockCountryCurrencyAdapter());
        $CurrencyAdapter->setCldrDir($this->mockCldrDir());
        $CurrencyAdapter->setLocaleService($this->mockLocaleService());
        return $CurrencyAdapter;
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