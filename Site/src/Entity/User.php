<?php
namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    private string $user_Login;

    #[ORM\Column(type: 'string', length: 255)]
    private string $user_Password;

    #[ORM\Column(type: 'string', length: 255)]
    private string $user_Name;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private bool $is_Translator = false;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private bool $is_Product_Owner = false;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'user')]
    private Collection $projects;

    #[ORM\OneToMany(targetEntity: Source::class, mappedBy: 'sourceTranslator')]
    private Collection $sources;

    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'users')]
    private Collection $languages;
    #[ORM\JoinTable(name: 'user_language')]

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private bool $user_state = false; 



    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUserLogin(string $user_Login): static
    {
        $this->user_Login = $user_Login;

        return $this;
    }


    public function setUserPassword(?string $user_Password): static
    {
        $this->user_Password = $user_Password;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_Name;
    }

    public function setUserName(string $user_Name): static
    {
        $this->user_Name = $user_Name;

        return $this;
    }

    public function getIsTranslator(): ?bool
    {
        return $this->is_Translator;
    }

    public function setIsTranslator(bool $is_Translator): static
    {
        $this->is_Translator = $is_Translator;

        return $this;
    }
    public function getIsProductOwner(): ?bool
    {
        return $this->is_Product_Owner;
    }

    public function setIsProductOwner(bool $is_Product_Owner): static
    {
        $this->is_Product_Owner = $is_Product_Owner;

        return $this;
    }

    public function getUserState(): ?bool
    {
        return $this->user_state;
    }
    public function setUserState(bool $user_state) : static
    {   
        $this->user_state = $user_state;
        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
      //Null atm mais obligatoire haha on rigole bien
    }

    public function getPassword(): ?string
    {
        return $this->user_Password;
    }

    public function getUserIdentifier(): string
    {
        return $this->user_Login; 
    }

}
   
