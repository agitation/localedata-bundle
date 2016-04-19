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
    public function testGetTimezones($code, $nameEn, $nameDe)
    {
        $timezoneAdapter = $this->createInstance();
        $timezones = $timezoneAdapter->getTimezones();

        $this->assertTrue(is_array($timezones));
        $this->assertArrayHasKey($code, $timezones);
        $this->assertEquals($code, $timezones[$code]->getCode());
        $this->assertEquals($nameEn, $timezones[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $timezones[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerTimezones
     */
    public function testGetTimezone($code, $nameEn, $nameDe)
    {
        $timezoneAdapter = $this->createInstance();
        $timezone = $timezoneAdapter->getTimezone($code);
        $this->assertTrue(is_object($timezone));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Timezone', get_class($timezone));
        $this->assertEquals($nameEn, $timezone->getName('en_GB'));
        $this->assertEquals($nameDe, $timezone->getName('de_DE'));
    }

    public function createInstance()
    {
        $timezoneAdapter = new TimezoneAdapter($this->mockCountryAdapter());
        $timezoneAdapter->setCldrDir($this->mockCldrDir());
        $timezoneAdapter->setLocaleService($this->mockLocaleService());
        return $timezoneAdapter;
    }

    public function providerTimezones()
    {
        return [
            ['Europe/Berlin', 'Germany, Berlin', 'Deutschland, Berlin'],
            ['Europe/London', 'United Kingdom, London', 'Vereinigtes Königreich, London']
        ];
    }
}
