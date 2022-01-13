<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Cassandra\Smallint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email indiqué est déja utilisé"
 * )
 * @method string getUserIdentifier()
 */
class User implements UserInterface


{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "L'email n'est pas valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="7", minMessage="7 caractères minimum")
     */
    private $password;


    /**
     * @ORM\OneToMany(targetEntity=AdvertLike::class, mappedBy="user")
     */
    private $likes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    private $superuser;
    /**
     * @Assert\EqualTo(propertyPath="password",message="Vos mots de passes ne correspondent pas")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return Collection|AdvertLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(AdvertLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(AdvertLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getSuperuser(): ?bool
    {
        return $this->superuser;
    }

    public function setSuperuser(?bool $superuser): self
    {
        $this->superuser = $superuser;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }


    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}
