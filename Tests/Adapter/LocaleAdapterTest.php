<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\LocaleAdapter;

class LocaleAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerLocales
     */
    public function testGetLocaleList($code, $nameEn, $nameDe)
    {
        $LocaleAdapter = $this->createInstance();
        $LocaleList = $LocaleAdapter->getLocaleList();

        $this->assertTrue(is_array($LocaleList));
        $this->assertArrayHasKey($code, $LocaleList);
        $this->assertEquals($code, $LocaleList[$code]->getCode());
        $this->assertEquals($nameEn, $LocaleList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $LocaleList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerLocales
     */
    public function testGetLocale($code, $nameEn, $nameDe)
    {
        $LocaleAdapter = $this->createInstance();
        $Locale = $LocaleAdapter->getLocale($code);
        $this->assertTrue(is_object($Locale));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Locale', get_class($Locale));
        $this->assertEquals($nameEn, $Locale->getName('en_GB'));
        $this->assertEquals($nameDe, $Locale->getName('de_DE'));
    }

    public function createInstance()
    {
        $LocaleAdapter = new LocaleAdapter($this->mockCountryAdapter());
        $LocaleAdapter->setCldrDir($this->mockCldrDir());
        $LocaleAdapter->setLocaleService($this->mockLocaleService());
        return $LocaleAdapter;
    }

    public function providerLocales()
    {
        return [
            ['de_DE', 'German', 'Deutsch'],
            ['en_GB', 'English', 'Englisch']
        ];
    }
}