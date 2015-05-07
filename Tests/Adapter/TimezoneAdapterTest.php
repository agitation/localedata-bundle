<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

class TimezoneAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerTimezones
     */
    public function testGetTimezoneList($code, $nameEn, $nameDe)
    {
        $TimezoneAdapter = $this->createInstance();
        $TimezoneList = $TimezoneAdapter->getTimezoneList();

        $this->assertTrue(is_array($TimezoneList));
        $this->assertArrayHasKey($code, $TimezoneList);
        $this->assertEquals($code, $TimezoneList[$code]->getCode());
        $this->assertEquals($nameEn, $TimezoneList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $TimezoneList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerTimezones
     */
    public function testGetTimezone($code, $nameEn, $nameDe)
    {
        $TimezoneAdapter = $this->createInstance();
        $Timezone = $TimezoneAdapter->getTimezone($code);
        $this->assertTrue(is_object($Timezone));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Timezone', get_class($Timezone));
        $this->assertEquals($nameEn, $Timezone->getName('en_GB'));
        $this->assertEquals($nameDe, $Timezone->getName('de_DE'));
    }

    public function createInstance()
    {
        $TimezoneAdapter = new TimezoneAdapter($this->mockCountryAdapter());
        $TimezoneAdapter->setCldrDir($this->mockCldrDir());
        $TimezoneAdapter->setLocaleService($this->mockLocaleService());
        return $TimezoneAdapter;
    }

    public function providerTimezones()
    {
        return [
            ['Europe/Berlin', 'Germany, Berlin', 'Deutschland, Berlin'],
            ['Europe/London', 'United Kingdom, London', 'Vereinigtes Königreich, London']
        ];
    }
}
