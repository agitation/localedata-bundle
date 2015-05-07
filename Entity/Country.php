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
use Agit\IntlBundle\Service\Translate;
use Agit\CoreBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity
 */
class Country extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=2,unique=true)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Currency")
     */
    protected $Currency;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return Translate::x($this->name, 'loc country');
    }

    /**
     * Get Currency
     *
     * @return \Agit\LocaleDataBundle\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->Currency;
    }
}