<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'medium_id'        => $row['medium_id'],           // Match with the column in Excel
            'student_id'       => $row['student_id'],          // Match with the column in Excel
            'name'             => $row['name'],                // Match with the column in Excel
            'slug'             => $row['slug'],                // Match with the column in Excel
            'image'            => $row['image'],               // Match with the column in Excel
            'roll'             => $row['roll'],                // Match with the column in Excel
            'class'            => $row['class'],               // Match with the column in Excel
            'section'          => $row['section'],             // Match with the column in Excel
            'guardian_name'    => $row['guardian_name'],       // Match with the column in Excel
            'guardian_contact' => $row['guardian_contact'],    // Match with the column in Excel
            'address'          => $row['address'],             // Match with the column in Excel
            'status'           => $row['status'], 
        ]);
    }
}
