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
    public function testGetMonthList($code, $nameEn, $nameDe)
    {
        $TimeAdapter = $this->createInstance();
        $MonthList = $TimeAdapter->getMonthList();

        $this->assertTrue(is_array($MonthList));
        $this->assertArrayHasKey($code, $MonthList);
        $this->assertEquals($code, $MonthList[$code]->getCode());
        $this->assertEquals($nameEn, $MonthList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $MonthList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerMonths
     */
    public function testGetMonth($code, $nameEn, $nameDe)
    {
        $TimeAdapter = $this->createInstance();
        $Month = $TimeAdapter->getMonth($code);
        $this->assertTrue(is_object($Month));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Month', get_class($Month));
        $this->assertEquals($nameEn, $Month->getName('en_GB'));
        $this->assertEquals($nameDe, $Month->getName('de_DE'));
    }

    /**
     * @dataProvider providerWeekdays
     */
    public function testGetWeekdayList($code, $nameEn, $nameDe)
    {
        $TimeAdapter = $this->createInstance();
        $WeekdayList = $TimeAdapter->getWeekdayList();

        $this->assertTrue(is_array($WeekdayList));
        $this->assertArrayHasKey($code, $WeekdayList);
        $this->assertEquals($code, $WeekdayList[$code]->getCode());
        $this->assertEquals($nameEn, $WeekdayList[$code]->getName('en_GB'));
        $this->assertEquals($nameDe, $WeekdayList[$code]->getName('de_DE'));
    }

    /**
     * @dataProvider providerWeekdays
     */
    public function testGetWeekday($code, $nameEn, $nameDe)
    {
        $TimeAdapter = $this->createInstance();
        $Weekday = $TimeAdapter->getWeekday($code);
        $this->assertTrue(is_object($Weekday));
        $this->assertEquals('Agit\LocaleDataBundle\Adapter\Object\Weekday', get_class($Weekday));
        $this->assertEquals($nameEn, $Weekday->getName('en_GB'));
        $this->assertEquals($nameDe, $Weekday->getName('de_DE'));
    }

    public function createInstance()
    {
        $TimeAdapter = new TimeAdapter();
        $TimeAdapter->setCldrDir($this->mockCldrDir());
        $TimeAdapter->setLocaleService($this->mockLocaleService());
        return $TimeAdapter;
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