<?php

declare(strict_types=1);

namespace App\Imports;

use App\Category;
use App\Rubric;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ProductsCollectionImport implements ToCollection, WithStartRow
{
    private const START_ROW = 2;

    /**
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows): void
    {
        $insertCount = $rows->count();
        $incorrectRows = 0;
        $uniqueRows = $rows->unique();
        $duplicates = $insertCount - $uniqueRows->count();
        $fileRubricsArr = [];
        $fileCategoriesArr = [];

        foreach ($uniqueRows as $row)
        {
            if (!is_null($row[0])) {
                $fileRubricsArr[] = $row[0];
            }
            if (!is_null($row[1])) {
                $fileRubricsArr[] = $row[1];;
            }
            if (!is_null($row[2])) {
                $fileCategoriesArr[] = $row[2];
            }
        }

        $fileRubricsArr = array_unique($fileRubricsArr);
        $fileCategoriesArr = array_unique($fileCategoriesArr);

        $rubricsInsert = [];
        foreach ($fileRubricsArr as $rubricName) {
            $rubricsInsert[] = ['name' => $rubricName];
        }
        DB::table('rubrics')->insertOrIgnore($rubricsInsert);

        $categoriesInsert = [];
        foreach ($fileCategoriesArr as $categoryName) {
            $categoriesInsert[] = ['name' => $categoryName];
        }
        DB::table('categories')->insertOrIgnore($categoriesInsert);

        $productsArray = [];
        foreach ($uniqueRows as $row)
        {
            if (empty($row[0])) {
                $incorrectRows++;
                continue;
            };
            $productsArray[] = [
                'rubric_id' => Rubric::where('name', $row[0])->first()->id,
                'sub_rubric_id' => Rubric::where('name', $row[1])->first()->id,
                'category_id' => Category::where('name', $row[2])->first()->id,
                'manufacturer' => $row[3],
                'name' => $row[4],
                'code' => (int)$row[5],
                'description' => $row[6],
                'price' => (float)$row[7],
                'guarantee' => (int)$row[8],
                'availability' => (bool)$row[9],
            ];
        }
        DB::table('products')->insertOrIgnore($productsArray);

        $inserted = $insertCount - $duplicates - $incorrectRows;

        if (!empty($inserted)) {
            session()->flash('Inserted', $inserted);
        }
        if (!empty($incorrectRows)) {
            session()->flash('IncorrectRow', $incorrectRows);
        }
        if (!empty($duplicates)) {
            session()->flash('Duplicates', $duplicates);
        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return self::START_ROW;
    }
}
