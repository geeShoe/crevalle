<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 11:07 AM
 */
declare(strict_types=1);

namespace Geeshoe\Crevalle;

use Geeshoe\Crevalle\Exception\CrevalleException;
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
     * @param string $table
     * @param string $title
     * @param string $content
     * @return string
     * @throws CrevalleException
     * @throws \Geeshoe\DbLib\Exceptions\DbLibException
     */
    public function addArticle(string $table, string $title, string $content): string
    {
        $dataArray = [
            'id' => $this->generateUUID(),
            'title' => filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS),
            'content' => filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS)
        ];

        $this->dblStatement->executePreparedInsertQuery(
            filter_var($table, FILTER_SANITIZE_SPECIAL_CHARS),
            $dataArray
        );

        return $dataArray['id'];
    }

    /**
     * @return string
     * @throws CrevalleException
     */
    protected function generateUUID(): string
    {
        try {
            return Uuid::uuid4()->toString();
        } catch (\Exception $exception) {
            throw new CrevalleException(
                'Unable to generate UUID.',
                0,
                $exception
            );
        }
    }
}
