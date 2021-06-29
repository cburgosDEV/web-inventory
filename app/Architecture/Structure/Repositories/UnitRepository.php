<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Unit;

class UnitRepository extends Unit
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'symbol' => '',
            'state' => true
        ];
    }

    public function getById($id)
    {
        return UnitRepository::select('unit.*')
            ->where('unit.id', $id)
            ->first();
    }

    public function store(Unit $unit)
    {
        if($unit->id == 0) {
            return $unit->save();
        } else {
            return $unit->update();
        }
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = UnitRepository::select('unit.*')
            ->where('unit.state', true)
            ->filtersToUnitIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
