<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User extends BaseEntity implements UserInterface
{
    use ResourceIdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="fistName", type="string", length=255)
     */
    private string $fistName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private string $lastName;
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez indiquer votre password")
     */
    private string $password;

    /**
     * @Assert\NotBlank(message="Vous devez indiquer votre password")
     * @Assert\EqualTo(propertyPath="password", message="La confirmation du mot de passe ne correspond pas")
     */
    public string $retypePassword;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @return string
     */
    public function getFistName(): string
    {
        return $this->fistName;
    }

    /**
     * @param string $fistName
     */
    public function setFistName(string $fistName): void
    {
        $this->fistName = $fistName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get username.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set username.
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(): int
    {
        return 0;
    }

    public function __construct()
    {
        $this->setRoles(['ROLE_USER']);
        parent::__construct(); //Call parents constructor
    }
}
