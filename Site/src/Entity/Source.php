<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'sources')]
    #[ORM\JoinColumn(nullable: false)]
    private Project $source_Project;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sources')]
    private ?User $source_Translator;

    #[ORM\Column(type: 'text')]
    private string $source_Content;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'nativeSources')]
    #[ORM\JoinColumn(nullable: false)]
    private Language $source_Native_Language;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'requireSources')]
    #[ORM\JoinColumn(nullable: false)]
    private Language $source_Require_Language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceProject(): ?int
    {
        return $this->Source_Project;
    }

    public function setSourceProject(int $Source_Project): static
    {
        $this->Source_Project = $Source_Project;

        return $this;
    }

    public function getSourceTranslator(): ?int
    {
        return $this->Source_Translator;
    }

    public function setSourceTranslator(?int $Source_Translator): static
    {
        $this->Source_Translator = $Source_Translator;

        return $this;
    }

    public function getSourceContent(): ?string
    {
        return $this->Source_Content;
    }

    public function setSourceContent(string $Source_Content): static
    {
        $this->Source_Content = $Source_Content;

        return $this;
    }

    public function getSourceNativeLanguage(): ?int
    {
        return $this->Source_Native_Language;
    }

    public function setSourceNativeLanguage(int $Source_Native_Language): static
    {
        $this->Source_Native_Language = $Source_Native_Language;

        return $this;
    }

    public function getSourceRequireLanguage(): ?int
    {
        return $this->Source_Require_Language;
    }

    public function setSourceRequireLanguage(int $Source_Require_Language): static
    {
        $this->Source_Require_Language = $Source_Require_Language;

        return $this;
    }
}
