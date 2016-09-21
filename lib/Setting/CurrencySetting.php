<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Setting;

use Agit\IntlBundle\Tool\Translate;
use Agit\LocaleDataBundle\Entity\CurrencyRepository;
use Agit\SettingBundle\Exception\InvalidSettingValueException;
use Agit\SettingBundle\Service\AbstractSetting;

class CurrencySetting extends AbstractSetting
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getId()
    {
        return "agit.currency";
    }

    public function getName()
    {
        return Translate::t("Currency");
    }

    public function getDefaultValue()
    {
        return "EUR";
    }

    public function validate($value)
    {
        if (! $this->currencyRepository->find($value)) {
            throw new InvalidSettingValueException(Translate::t("The selected currency is invalid."));
        }
    }
}
