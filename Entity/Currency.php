<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 *
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Entity;

use Agit\BaseBundle\Entity\IdentityAwareTrait;
use Agit\IntlBundle\Tool\Translate;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\CurrencyRepository")
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("currency", $this->name);
    }

    public function jsonSerialize()
    {
        return [
            "id"   => $this->getId(),
            "name" => $this->getName()
        ];
    }
}
