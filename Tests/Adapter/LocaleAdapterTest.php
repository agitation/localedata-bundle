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
        $localeAdapter = $this->createInstance();
        $localeList = $localeAdapter->getLocaleList();

        $this->assertTrue(is_array($localeList));
        $this->assertArrayHasKey($code, $localeList);
        $this->assertEquals($code, $localeList[$code]->getCode());
        $this->assertEquals($nameEn, $localeList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $localeList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerLocales
     */
    public function testGetLocale($code, $nameEn, $nameDe)
    {
        $localeAdapter = $this->createInstance();
        $locale = $localeAdapter->getLocale($code);
        $this->assertTrue(is_object($locale));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Locale', get_class($locale));
        $this->assertEquals($nameEn, $locale->getName('en_GB'));
        $this->assertEquals($nameDe, $locale->getName('de_DE'));
    }

    public function createInstance()
    {
        $localeAdapter = new LocaleAdapter($this->mockCountryAdapter());
        $localeAdapter->setCldrDir($this->mockCldrDir());
        $localeAdapter->setLocaleService($this->mockLocaleService());
        return $localeAdapter;
    }

    public function providerLocales()
    {
        return [
            ['de_DE', 'German', 'Deutsch'],
            ['en_GB', 'English', 'Englisch']
        ];
    }
}