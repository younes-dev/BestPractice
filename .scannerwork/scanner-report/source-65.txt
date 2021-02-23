<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
//    protected Category $category;

    //cette méthode est executé avant chaque test, son homologue tearDown, est executé après chaque test
//    public function setUp():void
//    {
//        if (null === $this->category) {
//            $this->category = new Category();
//        }
//    }

    public function testIsSame(): void
    {
        $category = new  Category();
        $category->setName("category");
        self::assertSame($category->getName(),"category");

    }


    public function testIsTrue(): void
    {
        $category = $this->createMock(Category::class);
        $collection = $this->createMock(Collection::class);
        $category->method('getArticle')->willReturn($collection);
        $category->method('addArticle')->willReturn($category);
        $category->method('removeArticle')->willReturn($category);

        self::assertInstanceOf(Category::class, $category);
    }

    public function testAddArticle(): void
    {
        $category=new Category();
        $category->setName("category");
        $date=new \DateTime('now');
        $article = new Article();

        $article->setCategory($category);
        $category->addArticle($article);

        $listArticle = $category->getArticle();
        $category->removeArticle($article);

        self::assertTrue(true);
        self::assertSame($category->getName(), "category");
        //self::assertInstanceOf($category, Category::class);
        self::assertNull($category->getId());
    }

    public function testIsFalse(): void
    {

        $category = new  Category();
        $category->setName("category");

        self::assertNotSame($category->getName(), "falseCategory");

    }

    public function testArticleCreate(): void
    {
        $category = new  Category();  // Create Category Object.
        $category->setName("category");

        self::assertEquals("category", $category->getName());


    }

}
