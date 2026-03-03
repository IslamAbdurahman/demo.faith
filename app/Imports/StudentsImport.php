<?php

namespace App\Imports;

use App\Models\Students;
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
        return $row;
//        $students = Students::all()->count();
//        $limit = limit_students();
//
//        if ($limit > $students){
//
//            $student = Students::firstOrCreate([
//                'name'=>$row[1],
//                'phone'=>$row[4],
//            ]);
//
//            if ($row[2] == 0 || $row[2] == 'female'){
//                $gender = 'female';
//            }else{
//                $gender = 'male';
//            }
//
//            $student->gender = $gender;
//            $student->birth_date = date('Y-m-d',strtotime($row[3]));
//            $student->parent_phone = $row[5];
//
//            return $student;
//        }

    }
}
