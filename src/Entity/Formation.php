<?php
namespace App\Entity;
use App\Entity\Artiste;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Formation
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @ORM\Table(name="formation", indexes={@ORM\Index(name="type", columns={"type"}, name="artist", columns={"artiste"})})
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Title cannot be blank.")
     * @Assert\Length(max=80, maxMessage="Title should not exceed {{ limit }}" )
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank(message="Description cannot be blank.")
     * @Assert\Length(max=200, maxMessage="Title should not exceed {{ limit }}" )
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="Link cannot be blank.")
     * @Assert\Length(max=255, maxMessage="Title should not exceed {{ limit }}" )
     * @Assert\Url(message="Invalid link provided.")
     * @ORM\Column(name="lien", type="string", length=255, nullable=false)
     */
    private $lien;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Assert\GreaterThanOrEqual("today", message="Date cannot be in the past.")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="archive", type="string", length=255, nullable=false, options={"default"="false"})
     */
    private $archive = 'false';

    /**
     * @var \Artiste
     * @Assert\NotBlank(message="Artiste cannot be blank.")
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="artiste", referencedColumnName="login", nullable=false)
     * })
     */
    private $artiste;

    /**
     * @var \Categorie
     * @Assert\NotBlank(message="Type cannot be blank.")
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="type", nullable=false)
     * })
     */
    private $type;

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function getArchive(): ?string
    {
        return $this->archive;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function getType(): ?Categorie
    {
        return $this->type;
    }

    // Setters

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function setArchive(string $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function setArtiste(Artiste $artiste)
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function setType(Categorie $type)
    {
        $this->type = $type;

        return $this;
    }


}
