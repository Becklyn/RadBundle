<?php declare(strict_types=1);

namespace Becklyn\RadBundle\Pagination\Data;

/**
 * Generic value object for returning paginated lists.
 *
 * @phpstan-template T
 */
class PaginatedList
{
    /**
     * @var iterable
     */
    private $list;


    /**
     * @var Pagination
     */
    private $pagination;


    public function __construct (iterable $list, Pagination $pagination)
    {
        $this->list = $list;
        $this->pagination = $pagination;
    }


    /**
     * @phpstan-return iterable<T>
     */
    public function getList () : iterable
    {
        return $this->list;
    }


    /**
     */
    public function getPagination () : Pagination
    {
        return $this->pagination;
    }


    /**
     *
     */
    public static function createFromArray (array $list) : self
    {
        $itemsPerPage = \max(1, \count($list));

        return new self(
            $list,
            new Pagination(1, $itemsPerPage, $itemsPerPage)
        );
    }
}
