<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\BaseEntity;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{

//    public function testConstruct(): void
//    {
//     $baseEntity = new BaseEntity();
//     //$baseEntity->getCreatedAt();
//    }

    public function testIsSame(): void
    {
        $category = new  Category();
        $category->setName("category");
        self::assertSame($category->getName(),"category");

        $date=new \DateTime('now');
        $article = new Article();
        $article->setName("name")
                ->setContent("content")
                ->setAuthor("author")
                ->setCategory($category)
                ->setCreatedAt($date)
                ->setUpdatedAt($date);

        self::assertSame($article->getName(),"name");
        self::assertSame($article->getContent(),"content");
        self::assertSame($article->getAuthor(),"author");
        self::assertSame($article->getCategory(),$category);
        self::assertSame($article->getCreatedAt(),$date);
        self::assertSame($article->getUpdatedAt(),$date);
    }


    public function testIsTrue(): void
    {
        $category = new  Category();
        $category->setName("category");
        self::assertSame($category->getName(),"category");

        $date=new \DateTime('now');
        $article = new Article();
        $article->setName("name")
                ->setContent("content")
                ->setAuthor("author")
                ->setCategory($category)
                ->setCreatedAt($date)
                ->setUpdatedAt($date);

        self::assertTrue($article->getName() === 'name');
        self::assertTrue($article->getContent() === 'content');
        self::assertTrue($article->getAuthor() === 'author');
        self::assertTrue($article->getCategory() === $category);
        self::assertTrue($article->getCreatedAt() === $date);
        self::assertTrue($article->getUpdatedAt() === $date);
    }

   public function testIsFalse(): void
    {
        $category = new  Category();
        $category->setName("category");

        $date=new \DateTime("2021-02-20");
        $date2=new \DateTime('now');
        $article = new Article();
        $article->setName("name")
                ->setContent("content")
                ->setAuthor("author")
                ->setCategory($category)
                ->setCreatedAt($date)
                ->setUpdatedAt($date2);

        self::assertNotSame($article->getName(), "falseName");
        self::assertNotSame($article->getContent(), "falseContent");
        self::assertNotSame($article->getAuthor() , "falseAuthor");
        self::assertNotSame($article->getCategory() , "");
        self::assertNotSame($article->getCreatedAt() , "");
        self::assertNotSame($article->getUpdatedAt() , "");
    }



    public function testArticleCreate(): void
    {
        $date=new \DateTime('now'); // Create DateTime Object.

        $article = new Article();	// Create Article object.
        $article->setName("name");
        $article->setContent("content");
        $article->setAuthor("author");
        $article->setCreatedAt($date);
        $article->setUpdatedAt($date);
        $category = new  Category();  // Create Category Object.
        $category->setName("category");
        $article->setCategory($category);

        self::assertEquals("name", $article->getName());
        self::assertEquals("content", $article->getContent());
        self::assertEquals("author", $article->getAuthor());
        self::assertEquals($date, $article->getCreatedAt());
        self::assertEquals($date, $article->getUpdatedAt());
        self::assertEquals($category, $article->getCategory());

    }

}
