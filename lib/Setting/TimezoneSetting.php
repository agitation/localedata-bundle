<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Setting;

use Agit\IntlBundle\Tool\Translate;
use Agit\LocaleDataBundle\Entity\TimezoneRepository;
use Agit\SettingBundle\Exception\InvalidSettingValueException;
use Agit\SettingBundle\Service\AbstractSetting;

class TimezoneSetting extends AbstractSetting
{
    private $timezoneRepository;

    public function __construct(TimezoneRepository $timezoneRepository)
    {
        $this->timezoneRepository = $timezoneRepository;
    }

    public function getId()
    {
        return "agit.timezone";
    }

    public function getName()
    {
        return Translate::t("Default Timezone");
    }

    public function getDefaultValue()
    {
        return "Europe/Berlin";
    }

    public function validate($value)
    {
        if (!$this->timezoneRepository->find($value))
            throw new InvalidSettingValueException(Translate::t("The selected timezone is invalid."));
    }
}
