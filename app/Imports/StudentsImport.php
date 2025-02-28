<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isNull;
use Maatwebsite\Excel\Concerns\ToModel;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     // Log the row data for debugging
    //     \Log::info('Importing Row:', $row);

    //     // Ensure proper column keys by checking the actual columns in the uploaded file
    //     $medium = isset($row['medium']) ? $row['medium'] : ''; // Ensure it exists
    //     $group = isset($row['group']) ? $row['group'] : ''; // Ensure it exists
    //     $section = isset($row['section']) ? $row['section'] : ''; // Ensure it exists
    //     $year = isset($row['year']) ? $row['year'] : ''; // Ensure it exists
    //     $roll = isset($row['roll']) ? $row['roll'] : ''; // Ensure it exists
    //     $class = isset($row['class']) ? $row['class'] : ''; // Ensure it exists
    //     $gender = isset($row['gender']) ? $row['gender'] : ''; // Ensure it exists

    //     // Check for missing values and handle them (optional)
    //     if (empty($medium) || empty($group) || empty($section) || empty($year) || empty($roll) || empty($gender)) {
    //         // Skip this row if necessary
    //         return null;
    //     }
    //     // if (empty($medium) || empty($group) || empty($section) || empty($year) || empty($roll)) {
    //     //     // Skip this row if necessary
    //     //     return null;
    //     // }

    //     // Generate student_id dynamically based on the formula
    //     $student_id = strtoupper(substr($gender, 0, 1)) .
    //         $year . $class . $roll;

    //     // Return the User model
    //     return new User([
    //         'student_id'       => $student_id,         // Dynamically generated student_id
    //         'roll'             => $roll,               // Roll number
    //         'name'             => $row['student_name'], // Student Name
    //         // 'slug'             => $student_id, // Slug (Optional)
    //         'gender'           => $row['gender'],       // Gender
    //         'guardian_name'    => $row['guardian_name'], // guardian's name (Guardian)
    //         'guardian_contact' => $row['guardian_number'], // guardian's contact number
    //         'class'            => $row['class'],        // Class
    //         'section'          => $section,             // Section
    //         'year'             => $year,               // Year
    //         'medium'           => $medium,              // Medium
    //         'group'            => $group,               // Group
    //         'status'           => 'active',             // Status, set to 'active'
    //     ]);
    // }
    // public function bindValue($cell, $value)
    // {
    //     // Force 'class' to be treated as a string
    //     if ($cell->getColumn() == 'F') {  // Assuming 'class' is column F
    //         $cell->setValueExplicit($value, DataType::TYPE_STRING);
    //     } else {
    //         $cell->setValueExplicit($value, DataType::TYPE_STRING);
    //     }
    // }
    public function model(array $row)
    {
        // \Log::info('Importing Row:', $row);
        // Force 'class' to be a string to preserve the leading zeros
        $medium = isset($row['medium']) ? $row['medium'] : null;
        $group = isset($row['group']) ? $row['group'] : null;
        $section = isset($row['section']) ? $row['section'] : null;
        $year = isset($row['year']) ? $row['year'] : null;
        $roll = isset($row['roll']) ? $row['roll'] : null;
        $class = isset($row['class']) ? $row['class'] : null;
        $class = trim($class, '"');
        if ($class === "00") {
            $class = '00';
        }
        elseif ($class === "0") {
            $class = '0';
        }else {
            $class =  $class ;

        }
// dd($class);
        $gender = isset($row['gender']) ? $row['gender'] : null;
        $errors = [];

        if (empty($gender)) {
            $errors[] = 'Gender is required for student at row: ' . json_encode($row);

        }
        if (empty($year)) {
            $errors[] = 'year is required for student at row: ' . json_encode($row);

        }
        if (empty($roll)) {
            $errors[] = 'roll is required for student at row: ' . json_encode($row);

        }
        if ($class === null || $class === "") {
            $errors[] = 'Class is required for student at row: ' . json_encode($row);
        }

        // dd($row);
        // dd($errors);

        if (count($errors) > 0) {
            return null;
            // throw new \Exception(implode(' ', $errors)); // Throw exception with concatenated error messages
        }
        // if (empty($medium) || empty($group) || empty($section) || empty($year) || empty($roll) || empty($gender)) {
        //     \Log::warning('Missing data for row, skipping: ', $row);
        //     return null;
        // }

        $student_id = strtoupper(substr($gender, 0, 1)) . $year . $class . $roll;

        try {
            return new User([
                'student_id'       => $student_id,
                'roll'             => $roll,
                'name'             => $row['student_name'],
                'gender'           => $row['gender'],
                'guardian_name'    => $row['guardian_name'],
                'guardian_contact' => $row['guardian_number'],
                'student_type'     => $row['student_type_oldnew'],
                'class'            => $class,
                'section'          => $section,
                'year'             => $year,
                'medium'           => $medium,
                'group'            => $group,
                'status'           => 'active',
            ]);
        } catch (\Exception $e) {
            // Log the error for this specific row
            Log::error('Error processing row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
            // Skip this row if error occurs
            return null;
        }
    }
}
