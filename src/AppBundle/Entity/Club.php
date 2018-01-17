<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Club
 *
 * @ORM\Table(name="club", indexes={@ORM\Index(name="FK_IDNOMCLUB_CLUB", columns={"intitule"})})
 * @ORM\Entity
 * @UniqueEntity(fields = "email", targetClass = "AppBundle\Entity\Utilisateur", message="fos_user.email.already_used")
 * @UniqueEntity(fields = "intitule", targetClass = "AppBundle\Entity\Club", message="Un compte existe déjà pour ce club. Contactez l'administrateur en cas de problème.")
 */
class Club extends Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\NomClub
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\NomClub")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="intitule", referencedColumnName="id")
     * })
     */
    private $intitule;

    // ...
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Evenement", mappedBy="club", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"dateModification" = "DESC"})
     */
    private $evenements;

    /**
     * @var \AppBundle\Entity\Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sportParDefaut", referencedColumnName="id", nullable=true)
     * })
     */
    private $sportParDefaut;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return NomClub
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * @param NomClub $intitule
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;
    }

    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @return Sport
     */
    public function getSportParDefaut()
    {
        return $this->sportParDefaut;
    }

    /**
     * @param Sport $sportParDefaut
     */
    public function setSportParDefaut($sportParDefaut)
    {
        $this->sportParDefaut = $sportParDefaut;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
    }

    public function __construct() {
        $this->evenements = new ArrayCollection();
    }
}

