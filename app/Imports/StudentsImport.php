<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Log the row data for debugging
        \Log::info('Importing Row:', $row);

        // Ensure proper column keys by checking the actual columns in the uploaded file
        $medium = isset($row['medium']) ? $row['medium'] : ''; // Ensure it exists
        $group = isset($row['group']) ? $row['group'] : ''; // Ensure it exists
        $section = isset($row['section']) ? $row['section'] : ''; // Ensure it exists
        $year = isset($row['year']) ? $row['year'] : ''; // Ensure it exists
        $roll = isset($row['roll']) ? $row['roll'] : ''; // Ensure it exists
        $class = isset($row['class']) ? $row['class'] : ''; // Ensure it exists

        // Check for missing values and handle them (optional)
        if (empty($medium) || empty($group) || empty($section) || empty($year) || empty($roll)) {
            // Skip this row if necessary
            return null;
        }

        // Generate student_id dynamically based on the formula
        $student_id = strtoupper(substr($medium, 0, 1)) .
                      strtoupper(substr($group, 0, 1)) .
                      strtoupper($section) . '-' .
                      $year . $class . $roll;

        // Return the User model
        return new User([
            'student_id'       => $student_id,         // Dynamically generated student_id
            'roll'             => $roll,               // Roll number
            'name'             => $row['student_name'], // Student Name
            // 'slug'             => $student_id, // Slug (Optional)
            'gender'           => $row['gender'],       // Gender
            'guardian_name'    => $row['fathers_name'], // Father's name (Guardian)
            'guardian_contact' => $row['fathers_number'], // Father's contact number
            'class'            => $row['class'],        // Class
            'section'          => $section,             // Section
            'year'             => $year,               // Year
            'medium'           => $medium,              // Medium
            'group'            => $group,               // Group
            'status'           => 'active',             // Status, set to 'active'
        ]);
    }
}
