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
use Agit\IntlBundle\Translate;
use Agit\CommonBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\LanguageRepository")
 */
class Language extends AbstractEntity
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
     * The name of the language in its local language
     */
    protected $localName;

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
        return Translate::x($this->name, 'language');
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
}
