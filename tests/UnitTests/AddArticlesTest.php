<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 11:51 AM
 */

namespace Geeshoe\CrevalleTest\UnitTests;

use Geeshoe\Crevalle\AddArticles;
use Geeshoe\DbLib\Core\PreparedStatements;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class AddArticlesTest
 *
 * @package Geeshoe\CrevalleTest\UnitTests
 */
class AddArticlesTest extends TestCase
{
    /**
     * @var MockObject|PreparedStatements
     */
    public $preparedStatementsMock;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->preparedStatementsMock = $this->getMockBuilder(PreparedStatements::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @throws \Exception
     */
    public function testAddArticleReturnsValidUUIDv4(): void
    {
        $article = new AddArticles($this->preparedStatementsMock);
        $uuid = $article->addArticle('someTitle', 'someContent');
        $this->assertSame(36, strlen($uuid));
    }
}
