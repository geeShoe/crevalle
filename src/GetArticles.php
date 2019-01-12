<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/9/19 - 7:38 AM
 */
declare(strict_types=1);

namespace Geeshoe\Crevalle;

use Geeshoe\Crevalle\Exception\CrevalleException;
use Geeshoe\DbLib\Core\Objects;
use Geeshoe\DbLib\Exceptions\DbLibQueryException;

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
     * @throws CrevalleException
     */
    public function getAllArticles(string $table): array
    {
        try {
            $results = $this->dblObjects->queryDbGetAllResultsAsClass(
                'SELECT * FROM ' . $table . ';',
                Article::class
            );
        } catch (DbLibQueryException $exception) {
            throw new CrevalleException(
                'Unable to retrieve articles from DB.',
                0,
                $exception
            );
        }

        return $results;
    }
}
