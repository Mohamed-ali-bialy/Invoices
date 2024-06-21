<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductsExport implements FromArray , WithHeadings, WithMapping , WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*
    public function collection()
    {
        return Product::all();
    }
    */

    //use Exportable;
    protected $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function array(): array
    {
        return $this->products;
    }

    public function headings(): array
    {
        // Define the headers for your Excel sheet
        return [
            'Product Code',
            'Product Name',
            'stock',
            'status',
            'Price',
            'discount',
            //'Category Id',
            //'Manufacturer Id',
            //'Created At',
            //'updated at',
            //'status',
            // Add more headers as needed
        ];
    }


    public function map($products): array
    {
        // Map each invoice to an array representing a row in the Excel sheet
        return [
            $products['product_Code'],
            $products['name'],
            $products['stock'],
            $products['status'],
            $products['price'],
            $products['discount'],
           // $products['amount'],
            // Add more columns as needed
        ];
    }

    /*
    //only with form 
    public function startCell(): string
    {
        return 'B2';
    }
    */
}
