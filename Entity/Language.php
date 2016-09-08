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
use Agit\IntlBundle\Tool\Translate;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\LanguageRepository")
 */
class Language
{
    use IdentityAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=5)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * The name of the language in its local language
     */
    protected $localName;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("language", $this->name);
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
