<?php

namespace App\Interfaces;

interface CrudComponent {
    public function create();
    public function delete($id);
    public function restore($id);
    public function forceDelete($id);
    public function clearFilters();
}
