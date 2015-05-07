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
class Locale extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=5,unique=true)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=30)
     */
    protected $name;

    /**
     * @ORM\Column(type="string",length=30)
     *
     * The name of the locale in its local language
     */
    protected $localName;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $Country;

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
        return Translate::x($this->name, 'loc language');
    }

    /**
     * Get localName
     *
     * @return string
     */
    public function getLocalName()
    {
        return $this->localName;
    }

    /**
     * Get Country
     *
     * @return \Agit\LocaleDataBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->Country;
    }
}