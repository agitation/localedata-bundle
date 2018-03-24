<?php
declare(strict_types=1);

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Entity;

use Agit\BaseBundle\Entity\IdentityAwareTrait;
use Agit\IntlBundle\Tool\Translate;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\CurrencyRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Currency implements JsonSerializable
{
    use IdentityAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=3)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * @ORM\Column(type="string",length=4)
     */
    protected $symbol;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $digits;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x('currency', $this->name);
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    public function getDigits()
    {
        return $this->digits;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'symbol' => $this->getSymbol(),
            'digits' => $this->getDigits()
        ];
    }
}
