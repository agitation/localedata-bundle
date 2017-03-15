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
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\LanguageRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("language", $this->name);
    }

    /**
     * Get localName.
     *
     * @return string
     */
    public function getLocalName()
    {
        return $this->localName;
    }
}
