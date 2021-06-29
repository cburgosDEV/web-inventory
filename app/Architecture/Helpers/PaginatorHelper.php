<?php

namespace App\Architecture\Helpers;

class PaginatorHelper
{
    public $total;
    public $current_page;
    public $per_page;
    public $last_page;
    public $from;
    public $to;

    public function paginateModel($model)
    {
        $this->total        = $model->total();
        $this->current_page = $model->currentPage();
        $this->per_page     = $model->perPage();
        $this->last_page    = $model->lastPage();
        $this->from         = $model->firstItem();
        $this->to           = $model->lastItem();

        return $this;
    }
}
