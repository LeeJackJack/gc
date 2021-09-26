<?php

namespace App\Imports;

use App\Models\excel\Haizhu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Speedy;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HaiZhuReport implements WithMultipleSheets
{
    public function sheets():array
    {
        return [
            '调查表' => new FirstSheetImport(),
        ];
    }

}
