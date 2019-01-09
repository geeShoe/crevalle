<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 1:59 PM
 */

namespace Geeshoe\CrevalleTest\FunctionalTests;

use Geeshoe\Crevalle\AddArticles;
use Geeshoe\Crevalle\Article;
use Geeshoe\DbLib\Core\PreparedStatements;
use PHPUnit\Framework\TestCase;

/**
 * Class AddArticlesTest
 *
 * @package Geeshoe\CrevalleTest\FunctionalTests
 */
class AddArticlesTest extends TestCase
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var PreparedStatements
     */
    protected $preparedStatement;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $host = getenv('GSD_CTDB_HOST');
        $port = getenv('GSD_CTDB_PORT');

        $this->pdo = new \PDO(
            'mysql:host=' . $host . ';port=' . $port,
            getenv('GSD_CTDB_USER'),
            getenv('GSD_CTDB_PASSWORD')
        );

        $this->createTempDB();
        $this->pdo->exec('USE ' . getenv('GSD_CTDB_DATABASE').';');
        $this->createTestTable();

        $this->preparedStatement = new PreparedStatements($this->pdo);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->removeTestSchema();
        $this->pdo = null;
    }

    /**
     * @return int
     */
    protected function removeTestSchema(): int
    {
        return $this->pdo->exec(
            'DROP SCHEMA`' . getenv('GSD_CTDB_DATABASE') . '`;'
        );
    }

    /**
     * @return int
     */
    protected function createTestSchema(): int
    {
        return $this->pdo->exec(
            'CREATE SCHEMA`' . getenv('GSD_CTDB_DATABASE') . '`;'
        );
    }

    protected function createTempDB(): void
    {
        $result = $this->createTestSchema();

        if ($result !== 1) {
            $this->removeTestSchema();
            $result = $this->createTestSchema();
        }

        if ($result !== 1) {
            throw new \PDOException(
                'Unable to create test schema.'
            );
        }
    }

    protected function createTestTable(): void
    {
        $sql = file_get_contents(dirname(__DIR__, 2) . '/crevalleTables.sql');
        $this->pdo->exec($sql);
    }

    /**
     * @throws \Geeshoe\DbLib\Exceptions\DbLibQueryException
     * @throws \Exception
     */
    public function testArticleIsAddedToDB(): void
    {
        $add = new AddArticles($this->preparedStatement);

        $uuid = $add->addArticle('MyArticle', 'MyContent');

        $article = $this->preparedStatement->executePreparedFetchAsClass(
            'SELECT * FROM crevalle_articles WHERE id = :id;',
            ['id' => $uuid],
            Article::class
        );

        $this->assertSame('MyArticle', $article->title);
        $this->assertSame('MyContent', $article->content);
        $this->assertSame($uuid, $article->id);
    }
}
