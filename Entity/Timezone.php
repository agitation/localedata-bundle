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
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\TimezoneRepository")
 */
class Timezone extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=40,unique=true)
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
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Country
     *
     * @return \Agit\LocaleDataBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return Translate::getInstance()->x($this->name, 'timezone');
    }
}
