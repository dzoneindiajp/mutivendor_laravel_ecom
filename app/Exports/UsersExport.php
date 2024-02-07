<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    use Exportable;

    protected $selects;
    protected $rowCount;
    protected $columnCount;

    public function __construct()
    {
        // Retrieve predefined options for dropdowns
        $genders = ['Male', 'Female', 'Other'];

        // Define columns and their respective dropdown options
        $this->selects = [
            ['columns_name' => 'D', 'options' => $genders],
        ];
        $this->rowCount = User::where('is_deleted', 0)->count() + 1; // Adding 1 for the header row
        $this->columnCount = 6; // Number of columns in the Excel sheet
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('is_deleted', 0)->where('user_role_id', 2)->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone Number',
            'Gender',
            'Date Of Birth',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $row_count = $this->rowCount;
                $column_count = $this->columnCount;

                $hiddenSheet = $event->sheet->getDelegate()->getParent()->createSheet();
                $hiddenSheet->setTitle('Hidden');
                $hiddenSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];

                    // Populate hidden sheet with dropdown values
                    foreach ($options as $index => $option) {
                        $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1) . ($index + 1);
                        $hiddenSheet->setCellValue($cellCoordinate, $option);
                    }

                    // Set data validation formula to refer to hidden sheet cells
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1('Hidden!$A$1:$A$' . count($options));

                    // Clone validation to remaining rows
                    for ($i = 2; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }

                    // Set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }
            },
        ];
    }

    public function map($user): array
    {
        $status = $user->is_active == 1 ? "Active" : "Inactive";

        return [
            $user->name ?? null,
            $user->email ?? null,
            $user->phone_number ?? null,
            ucfirst($user->gender) ?? null,
            $user->date_of_birth ?? null,
            $status,
        ];
    }
}
