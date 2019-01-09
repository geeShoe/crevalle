<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 7:38 AM
 */
declare(strict_types=1);

namespace Geeshoe\Crevalle;

use Geeshoe\DbLib\Core\Objects;

/**
 * Class GetArticles
 *
 * @package Geeshoe\Crevalle
 */
class GetArticles
{
    /**
     * @var Objects
     */
    protected $dblObjects;

    /**
     * GetArticles constructor.
     *
     * @param Objects $DbLibObjects
     */
    public function __construct(Objects $DbLibObjects)
    {
        $this->dblObjects = $DbLibObjects;
    }

    /**
     * @param string $table
     * @return array
     * @throws \Geeshoe\DbLib\Exceptions\DbLibQueryException
     */
    public function getAllArticles(string $table): array
    {
        $results = $this->dblObjects->queryDbGetAllResultsAsClass(
            'SELECT * FROM '.$table.';',
            Article::class
        );

        return $results;
    }
}
