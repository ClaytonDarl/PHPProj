<?php
class Paginate {

    public $currPage; //page we are on
    public $items; //items per page
    public $totalItems; //total items in the Database table

    public function __construct($currPage=1, $items=3, $totalItems=0){
        $this->currPage = (int)$currPage;
        $this->items = (int)$items;
        $this->totalItems = (int)$totalItems;
    }

    public function next() {
        return $this->currPage + 1;
    }

    public function prev() {
        return $this->currPage - 1;
    }

    public function pageTotal() {
        return ceil($this->totalItems / $this->items);
    }

    public function hasNext() {
        return $this->next() <= $this->pageTotal() ? true : false;
    }

    public function hasPrev() {
        return $this->prev() >= 1 ? true : false;
    }

    //returns the offset for element display sets. IE page 2 should display items 4-6.
    public function offset() {
        return ($this->currPage - 1) * $this->items;
    }
}
?>