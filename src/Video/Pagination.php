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
        return $this->get('total', 1);
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
}
