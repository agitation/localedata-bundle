<?php

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

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\TimezoneRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Timezone
{
    use IdentityAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=40)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $country;

    /**
     * Get Country.
     *
     * @return \Agit\LocaleDataBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("timezone", $this->name);
    }
}
