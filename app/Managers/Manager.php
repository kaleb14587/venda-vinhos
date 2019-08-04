<?php


namespace App\Managers;


use Illuminate\Database\Eloquent\Builder;

abstract class Manager
{
    /**
     * @return mixed
     */
    abstract function baseQuery();

    /**
     * @param Builder $query
     * @param array $filters
     * @return mixed
     */
    abstract function filter(Builder &$query, array $filters);

    /**
     * @param Builder $query
     * @param array $orders
     * @return mixed
     */
    abstract function order(Builder &$query, array $orders);

    /**
     * @param array $filters
     * @param array $orderBy
     * @param $page
     * @param int $perpage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateData(array $filters, array $orderBy, $page, $perpage = 15) {
        /** @var Builder $qb */
        $qb = $this->baseQuery();
        $this->filter($qb, $filters);
        $this->order($qb, $orderBy);
        return $qb->paginate($perpage, '*', 'page', $page);
    }
}
