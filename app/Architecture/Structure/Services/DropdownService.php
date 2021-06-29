<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Structure\Repositories\DropdownRepository;

class DropdownService
{
    protected $dropdownRepository;

    public function __construct
    (
        DropdownRepository $dropdownRepository
    )
    {
        $this->dropdownRepository = $dropdownRepository;
    }

    public function UnitDropdown()
    {
        return $this->dropdownRepository->UnitDropdown();
    }

    public function SupplierDropdown()
    {
        return $this->dropdownRepository->SupplierDropdown();
    }

    public function ProductDropdown()
    {
        return $this->dropdownRepository->ProductDropdown();
    }

    public function CustomerDropdown()
    {
        return $this->dropdownRepository->CustomerDropdown();
    }
}
