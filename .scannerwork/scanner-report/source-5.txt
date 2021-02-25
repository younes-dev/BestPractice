<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Article extends BaseEntity
{
    use ResourceIdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nome ne doit pas etre vide")
     * @Assert\NotNull(message="Le nome ne doit pas etre null")
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le content ne doit pas etre vide")
     * @Assert\NotNull(message="Le content ne doit pas etre null")
     */
    private string $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le Auteur ne doit pas etre vide")
     * @Assert\NotNull(message="Le Auteur ne doit pas etre null")
     */
    private string $author;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="article")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="La Catégorie ne doit pas etre vide")
     * @Assert\NotNull(message="La Catégorie ne doit pas etre null")
     */
    private ?Category $category;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
