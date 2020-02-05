<?php

namespace Vientodigital\LaravelVimeo\Video;

class Pagination extends Base
{
    protected $_items = [];

    public function __construct($data)
    {
        parent::__construct($data);
        foreach ($this->get('data', []) as $item) {
            $this->_items[] = new Item($item);
        }
    }

    public function getItems($default = null)
    {
        return empty($this->_items)
            ? (!is_array($default) ? [] : $default)
            : $this->_items;
    }

    public function getItemsCount()
    {
        return count($this->_items);
    }

    public function getCurrentPage()
    {
        return $this->get('page', 1);
    }

    public function getNextPage()
    {
        return null === $this->getNextPageUrl()
            ? null
            : ($this->getCurrentPage() + 1);
    }

    public function getPreviousPage()
    {
        return null === $this->getPreviousPageUrl()
            ? null
            : ($this->getCurrentPage() - 1);
    }

    public function getFirstPage()
    {
        return 1;
    }

    public function getLastPage()
    {
        return ceil($this->get('total', 1) / $this->get('per_page', 5));
    }

    public function getPreviousPageUrl()
    {
        return $this->get('paging.previous', null);
    }

    public function getNextPageUrl()
    {
        return $this->get('paging.next', null);
    }

    public function getFirstPageUrl()
    {
        return $this->get('paging.first');
    }

    public function getLastPageUrl()
    {
        return $this->get('paging.last');
    }

    public function getRelativePagination($qty = 5)
    {
        $currentPage = $this->getCurrentPage();
        $totalPages = $this->getLastPage();

        $media = (int) ($qty / 2);
        $start = $currentPage - $media;
        $end = $currentPage + $media;
        $slots = [];

        if ($start < 1) {
            $start = 1;
            $end = $qty;
        }
        if ($end > $totalPages) {
            $start = $totalPages - $qty;
            $end = $totalPages;
            if ($start < 1) {
                $start = 1;
            }
        }

        $slots[] = [
            'active' => false,
            'label' => __('laravel-vimeo::words.first'),
            'disabled' => 1 === $currentPage,
            'url' => route('laravel-vimeo.me.index').'?page=1',
        ];

        $slots[] = [
            'active' => false,
            'label' => __('laravel-vimeo::words.previous'),
            'disabled' => 1 === $currentPage,
            'url' => route('laravel-vimeo.me.index').'?page='.($currentPage > 1 ? ($currentPage - 1) : '1'),
        ];

        for ($n = $start; $n <= $end; ++$n) {
            $slots[] = [
                'active' => $n === $currentPage,
                'label' => $n,
                'url' => route('laravel-vimeo.me.index').'?page='.$n,
                'disabled' => false,
            ];
        }

        $slots[] = [
            'active' => false,
            'label' => __('laravel-vimeo::words.next'),
            'disabled' => $totalPages === $currentPage,
            'url' => route('laravel-vimeo.me.index').'?page='.($totalPages === $currentPage ? $totalPages : ($currentPage + 1)),
        ];

        $slots[] = [
            'active' => false,
            'label' => __('laravel-vimeo::words.last'),
            'disabled' => $totalPages === $currentPage,
            'url' => route('laravel-vimeo.me.index').'?page='.$totalPages,
        ];

        return $slots;
    }
}
