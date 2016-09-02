<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Agit\BaseBundle\Entity\IdentityAwareTrait;
use Agit\IntlBundle\Translate;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\CountryRepository")
 */
class Country
{
    use IdentityAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=2)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=3)
     *
     * The official 3-letter code.
     */
    protected $code;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;
    /**
     * @ORM\Column(type="integer",length=4)
     */
    protected $phone;

    /**
     * @ORM\ManyToOne(targetEntity="Currency")
     */
    protected $currency;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("country", $this->name);
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get Currency
     *
     * @return \Agit\LocaleDataBundle\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
