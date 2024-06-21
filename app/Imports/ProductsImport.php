<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;


use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithEvents;

HeadingRowFormatter::default('none');

class ProductsImport implements ToModel, WithUpserts, WithUpsertColumns ,WithHeadingRow,PersistRelations,WithBatchInserts, WithChunkReading 
,WithValidation ,SkipsOnFailure,SkipsEmptyRows
{
    //, WithEvents
    //,ShouldQueue


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable, SkipsFailures, RemembersRowNumber;




    public function uniqueBy()
    {
        return 'product_Code';
    }

    public function upsertColumns()
    {
        return ['price','status','stock','discount'];
    }


    public function rules(): array
    {
        return [

            '*.Product Code' => ['required', 'integer', 'max:255'],
            '*.Price' => ['required', 'numeric', 'min:1.00'],
            '*.status' => ['required', 'string', Rule::in(['active', 'inactive'])],
            '*.stock' => ['required', 'integer', 'min:0'],
            '*.discount' => ['required', 'numeric', 'min:0', 'max:100'],

        ];
    }

    
    public function onFailure(Failure ...$failures)
    {
        // Log validation failures
        foreach ($failures as $failure) {
           /* Log::error('Import failure', [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ]);
            */
        }

        // Add to the internal failures array for later use if needed
        $this->failures = array_merge($this->failures, $failures);
    }

    public function model(array $row)
    {
        
        $productCode = $row['Product Code'] ?? $row['code'] ?? null;
        $name = $row['Product Name'] ?? $row['Name'] ?? null;
        $price = $row['Price'] ?? null;
        $status = $row['status']  ?? null;
        $stock = $row['Stock']  ?? $row['stock']  ?? null;
        $discount = $row['discount']  ?? null;

        if (is_null($productCode)  || is_null($name)||is_null($price) 
        || is_null($status)||is_null($stock) ||is_null($discount) ) {
            // Log the skipped row for debugging purposes if needed
            Log::warning('Skipped row due to missing ......', [
                'row' => $this->getRowNumber(),
                'data' => $row
            ]);
            // Return null to skip the row
            return null;
        }
        
        $currentRowNumber = $this->getRowNumber();

        $product =new Product([
            'product_Code'=>$row['Product Code']?? $row['code']?? null,
            'name'     => $row['Product Name']?? $row['Name']?? null,
            'price'    => $row['Price']?? null,
            'status'   => $row['status']?? null,
            'stock'    => $row['Stock']?? $row['stock']??null,
            'discount' => $row['discount']?? null,
            //'category_id'=> $row[6],
            //'manufacturer_id'=> $row[7],
               
         ]); 

         //$product->setRelation('team', new Team(['name' => $row[1]]));

        return $product;
    }

    

/*
    public function __construct(Product $importedBy)
    {
        $this->importedBy = $importedBy;
    }
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                $this->importedBy->notify(new ImportHasFailedNotification);
            },
        ];
    }
*/




    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
