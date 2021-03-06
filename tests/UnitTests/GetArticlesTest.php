<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 7:46 AM
 */

namespace Geeshoe\CrevalleTest\UnitTests;

use Geeshoe\Crevalle\Article;
use Geeshoe\Crevalle\Exception\CrevalleException;
use Geeshoe\Crevalle\GetArticles;
use Geeshoe\DbLib\Core\Objects;
use Geeshoe\DbLib\Exceptions\DbLibQueryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class GetArticlesTest
 *
 * @package Geeshoe\CrevalleTest\UnitTests
 */
class GetArticlesTest extends TestCase
{
    /**
     * @var MockObject|Objects
     */
    public $dblObjectsMock;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->dblObjectsMock = $this->getMockBuilder(Objects::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return array
     * @throws CrevalleException
     */
    public function getAllArticlesObjectSetup(): array
    {
        $this->dblObjectsMock->method('queryDbGetAllResultsAsClass')
            ->willReturn([new Article()]);

        $getArticles = new GetArticles($this->dblObjectsMock);
        return $getArticles->getAllArticles('someTable');
    }

    /**
     * @throws CrevalleException
     */
    public function testAssertGetAllArticlesReturnsAnArray(): void
    {
        $articleArray = $this->getAllArticlesObjectSetup();

        $this->assertIsArray($articleArray);
    }

    /**
     * @throws CrevalleException
     */
    public function testGetAllArticlesReturnsAnArrayOfArticles(): void
    {
        $articleArray = $this->getAllArticlesObjectSetup();

        foreach ($articleArray as $article) {
            $this->assertInstanceOf(Article::class, $article);
        }
    }

    public function testGetAllArticlesThrowsException(): void
    {
        $this->dblObjectsMock->method('queryDbGetAllResultsAsClass')
            ->willThrowException(new DbLibQueryException('Test'));

        $this->expectException(CrevalleException::class);
        $this->expectExceptionMessage('Unable to retrieve articles from DB.');

        $articles = new GetArticles($this->dblObjectsMock);
        $articles->getAllArticles('someTable');
    }
}
