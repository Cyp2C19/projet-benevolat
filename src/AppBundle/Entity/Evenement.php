<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="FK_IDSPORT_EVENEMENT", columns={"sport"}), @ORM\Index(name="FK_IDCLUB_EVENEMENT", columns={"club"}), @ORM\Index(name="FK_IDLIEU_EVENEMENT", columns={"lieu"}), @ORM\Index(name="FK_IDNIVEAU_EVENEMENT", columns={"niveau"}), @ORM\Index(name="FK_IDCATEGORIEAGE_EVENEMENT", columns={"categorieAge"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Length(
     *     max=40,
     *      maxMessage = "Le titre ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="titre", type="string", length=40, nullable=false)
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarifPlein", type="integer", nullable=true)
     */
    private $tarifPlein;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarifReduit", type="integer", nullable=true)
     */
    private $tarifReduit;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="La date de début doit être saisie")
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="date", nullable=false)
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaire", type="time", nullable=false)
     */
    private $horaire;

    /**
     * @var string
     * @Assert\Length(
     *     max=500,
     *      maxMessage = "La description ne doit pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var \AppBundle\Entity\CategorieAge
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CategorieAge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorieAge", referencedColumnName="id", nullable=false)
     * })
     */
    private $categorieAge;

    /**
     * @var \AppBundle\Entity\Club
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", inversedBy="evenements")
     * @ORM\JoinColumn(name="club", referencedColumnName="id")
     */
    private $club;

    /**
     * @var \AppBundle\Entity\Lieu
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lieu",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lieu", referencedColumnName="id", nullable=false)
     * })
     */
    private $lieu;

    /**
     * @var \AppBundle\Entity\Niveau
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Niveau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveau", referencedColumnName="id", nullable=false)
     * })
     */
    private $niveau;

    /**
     * @var \AppBundle\Entity\Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport", referencedColumnName="id", nullable=false)
     * })
     */
    private $sport;

    /**
     * @var \AppBundle\Entity\MissionBenevolat
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\MissionBenevolat", cascade={"persist"})
     * @ORM\JoinTable(name="demandesBenevolat",
     *      joinColumns={@ORM\JoinColumn(name="evenement", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mission", referencedColumnName="id")}
     *      )
     */

    private $demandesBenevolat;

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return int
     */
    public function getTarifPlein()
    {
        return $this->tarifPlein;
    }

    /**
     * @param int $tarifPlein
     */
    public function setTarifPlein($tarifPlein)
    {
        $this->tarifPlein = $tarifPlein;
    }

    /**
     * @return int
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * @param int $tarifReduit
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param \DateTime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return \DateTime
     */
    public function getHoraire()
    {
        return $this->horaire;
    }

    /**
     * @param \DateTime $horaire
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return CategorieAge
     */
    public function getCategorieAge()
    {
        return $this->categorieAge;
    }

    /**
     * @param CategorieAge $categorieAge
     */
    public function setCategorieAge($categorieAge)
    {
        $this->categorieAge = $categorieAge;
    }

    /**
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param Club $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }

    /**
     * @return Lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param Lieu $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param Niveau $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    /**
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport($sport)
    {
        $this->sport = $sport;
    }

    /**
     * @return MissionBenevolat
     */
    public function getDemandesBenevolat()
    {
        return $this->demandesBenevolat;
    }

    /**
     * @param MissionBenevolat $demandesBenevolat
     */
    public function setDemandesBenevolat($demandesBenevolat)
    {
        $this->demandesBenevolat = $demandesBenevolat;
    }

    public function addDemandesBenevolat($demande){
        $this->demandesBenevolat->add($demande);
    }

    public function removeDemandesBenevolat($demande){
        $this->demandesBenevolat->removeElement($demande);
    }

    /**
     * @return bool
     */
    public function contientDemandesBenevolat()
    {
        if(count($this->demandesBenevolat) > 0){
                return true;
        }
        return false;
    }

    public function __construct()
    {
        $this->demandesBenevolat = new ArrayCollection();
        $this->dateModification = new \DateTime();
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (!is_null($this->dateFin) && $this->dateFin < $this->dateDebut){
            $context->buildViolation('La date de début doit être avant la date de fin')
                ->atPath('dateDebut')
                ->addViolation();
        }
    }

}
