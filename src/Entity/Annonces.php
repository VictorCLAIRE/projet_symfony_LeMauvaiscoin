<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AnnoncesRepository::class)
 */
class Annonces
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_annonce;

    /**
     * @ORM\Column(type="text")
     */
    private $description_annonce;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_annonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=Regions::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $region_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAnnonce(): ?string
    {
        return $this->nom_annonce;
    }

    public function setNomAnnonce(string $nom_annonce): self
    {
        $this->nom_annonce = $nom_annonce;

        return $this;
    }
    public function getSlug(): string{
        return (new  Slugify ())->slugify -> slugify ( $this->nom_annonce );
    }

    public function getDescriptionAnnonce(): ?string
    {
        return $this->description_annonce;
    }

    public function setDescriptionAnnonce(string $description_annonce): self
    {
        $this->description_annonce = $description_annonce;

        return $this;
    }

    public function getPrixAnnonce(): ?float
    {
        return $this->prix_annonce;
    }

    public function setPrixAnnonce(float $prix_annonce): self
    {
        $this->prix_annonce = $prix_annonce;

        return $this;
    }

    public function getPhotoAnnonce(): ?string
    {
        return $this->photo_annonce;
    }

    public function setPhotoAnnonce(string $photo_annonce): self
    {
        $this->photo_annonce = $photo_annonce;

        return $this;
    }

    public function getCategorieAnnonce(): ?categories
    {
        return $this->categorie_annonce;
    }

    public function setCategorieAnnonce(categories $categorie_annonce): self
    {
        $this->categorie_annonce = $categorie_annonce;

        return $this;
    }

    public function getRegionAnnonce(): ?regions
    {
        return $this->region_annonce;
    }

    public function setRegionAnnonce(regions $region_annonce): self
    {
        $this->region_annonce = $region_annonce;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
