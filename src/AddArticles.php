<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 11:07 AM
 */
declare(strict_types=1);

namespace Geeshoe\Crevalle;

use Geeshoe\DbLib\Core\PreparedStatements;
use Ramsey\Uuid\Uuid;

/**
 * Class AddArticles
 *
 * @package Geeshoe\Crevalle
 */
class AddArticles
{
    /**
     * @var PreparedStatements
     */
    protected $dblStatement;

    /**
     * AddArticles constructor.
     *
     * @param PreparedStatements $preparedStatements
     */
    public function __construct(PreparedStatements $preparedStatements)
    {
        $this->dblStatement = $preparedStatements;
    }

    /**
     * @param string $title
     * @param string $content
     * @return string
     * @throws \Exception
     */
    public function addArticle(string $title, string $content): string
    {
        $dataArray = [
            'id' => $this->generateUUID(),
            'title' => filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS),
            'content' => filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS)
        ];

        $this->dblStatement->executePreparedInsertQuery(
            'crevalle_articles',
            $dataArray
        );

        return $dataArray['id'];
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateUUID(): string
    {
        return Uuid::uuid4()->toString();
    }
}
