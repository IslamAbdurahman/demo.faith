<?php

namespace App\Jobs;

use App\Imports\StudentsImport;
use App\Models\Students;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $array;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->array as $row) {
            $students = Students::all()->count();
            $limit = limit_students();

            if ($limit > $students) {
                if ($row[1]) {
                    $student = Students::firstOrCreate([
                        'name' => $row[1],
                    ]);

                    if ($row[2] == 0 || $row[2] == 'female') {
                        $gender = 'female';
                    } else {
                        $gender = 'male';
                    }
                    $student->gender = $gender;

                    $s_numbers = preg_replace('/\D/', '', $row[4]); // Extract only the numbers
                    $p_numbers = preg_replace('/\D/', '', $row[5]); // Extract only the numbers

// Check if the number is exactly 7 digits long
                    if (strlen($s_numbers) === 9) {
                        $s_numbers = '998' . $s_numbers;
                    }
// Check if the number is exactly 7 digits long
                    if (strlen($p_numbers) === 9) {
                        $p_numbers = '998' . $p_numbers;
                    }

                    $student->birth_date = $row[3] ? date('Y-m-d', strtotime($row[3])) : null;
                    $student->phone = $s_numbers ? $s_numbers : null;
                    $student->parent_phone = $p_numbers ? $p_numbers : null;

                    $student->save();

                }
            } else {
                break;
            }
        }

    }
}
