<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Categorie
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @ORM\Table(name="categorie", indexes={@ORM\Index(name="type", columns={"type"})})
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Type cannot be blank.")
     * @Assert\Length(max=50, maxMessage="Title should not exceed {{ limit }}" )
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     * @ORM\Id
     */
    private $type;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getType();
    }


}
