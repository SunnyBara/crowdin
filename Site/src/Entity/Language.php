<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $language_name;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'languages')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Source::class, mappedBy: 'source_Native_Language')]
    private Collection $native_Sources;

    #[ORM\OneToMany(targetEntity: Source::class, mappedBy: 'source_Require_Language')]
    private Collection $require_Sources;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->nativeSources = new ArrayCollection();
        $this->requireSources = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguageName(): ?string
    {
        return $this->language_name;
    }

    public function setLanguageName(string $language_name): static
    {
        $this->language_name = $language_name;

        return $this;
    }
}