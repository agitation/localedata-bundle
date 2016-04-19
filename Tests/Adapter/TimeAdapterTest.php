<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Tests\Adapter;

use Agit\LocaleDataBundle\Adapter\TimeAdapter;

class TimeAdapterTest extends AbstractAdapterTest
{
    /**
     * @dataProvider providerMonths
     */
    public function testGetMonths($code, $nameEn, $nameDe)
    {
        $timeAdapter = $this->createInstance();
        $months = $timeAdapter->getMonths();

        $this->assertTrue(is_array($months));
        $this->assertArrayHasKey($code, $months);
        $this->assertEquals($code, $months[$code]->getCode());
        $this->assertEquals($nameEn, $months[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $months[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerMonths
     */
    public function testGetMonth($code, $nameEn, $nameDe)
    {
        $timeAdapter = $this->createInstance();
        $month = $timeAdapter->getMonth($code);
        $this->assertTrue(is_object($month));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Month', get_class($month));
        $this->assertEquals($nameEn, $month->getName('en_GB'));
        $this->assertEquals($nameDe, $month->getName('de_DE'));
    }

    /**
     * @dataProvider providerWeekdays
     */
    public function testGetWeekdays($code, $nameEn, $nameDe)
    {
        $timeAdapter = $this->createInstance();
        $weekdays = $timeAdapter->getWeekdays();

        $this->assertTrue(is_array($weekdays));
        $this->assertArrayHasKey($code, $weekdays);
        $this->assertEquals($code, $weekdays[$code]->getCode());
        $this->assertEquals($nameEn, $weekdays[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $weekdays[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerWeekdays
     */
    public function testGetWeekday($code, $nameEn, $nameDe)
    {
        $timeAdapter = $this->createInstance();
        $weekday = $timeAdapter->getWeekday($code);
        $this->assertTrue(is_object($weekday));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Weekday', get_class($weekday));
        $this->assertEquals($nameEn, $weekday->getName('en_GB'));
        $this->assertEquals($nameDe, $weekday->getName('de_DE'));
    }

    public function createInstance()
    {
        $timeAdapter = new TimeAdapter();
        $timeAdapter->setCldrDir($this->mockCldrDir());
        $timeAdapter->setLocaleService($this->mockLocaleService());
        return $timeAdapter;
    }


    public function providerMonths()
    {
        return [
            ['1', 'January', 'Januar'],
            ['3', 'March', 'März'],
            ['12', 'December', 'Dezember']
        ];
    }

    public function providerWeekdays()
    {
        return [
            ['mon', 'Monday', 'Montag'],
            ['sat', 'Saturday', 'Samstag'],
            ['sun', 'Sunday', 'Sonntag']
        ];
    }
}