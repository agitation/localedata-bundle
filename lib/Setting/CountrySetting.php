<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Setting;

use Agit\IntlBundle\Tool\Translate;
use Agit\LocaleDataBundle\Entity\CountryRepository;
use Agit\SettingBundle\Exception\InvalidSettingValueException;
use Agit\SettingBundle\Service\AbstractSetting;

class CountrySetting extends AbstractSetting
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getId()
    {
        return "agit.country";
    }

    public function getName()
    {
        return Translate::t("Country");
    }

    public function getDefaultValue()
    {
        return "DE";
    }

    public function validate($value)
    {
        if (! $this->countryRepository->find($value)) {
            throw new InvalidSettingValueException(Translate::t("The selected country is invalid."));
        }
    }
}
