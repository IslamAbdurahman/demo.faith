<?php

namespace App\Observers;

use App\Models\Graphic;
use App\Models\StudentGroup;

class StudentGroupObserver
{
    /**
     * Handle the StudentGroup "created" event.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return void
     */
    public function created(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Handle the StudentGroup "updated" event.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return void
     */
    public function updated(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Handle the StudentGroup "deleted" event.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return void
     */
    public function deleting(StudentGroup $studentGroup)
    {
        $graphics = Graphic::where('student_id','=',$studentGroup->getOriginal('student_id'))
        ->where('group_id','=',$studentGroup->getOriginal('group_id'))
        ->where('paid_amount','=',0);

        $graphics->delete();
    }

    /**
     * Handle the StudentGroup "restored" event.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return void
     */
    public function restored(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Handle the StudentGroup "force deleted" event.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return void
     */
    public function forceDeleted(StudentGroup $studentGroup)
    {
        //
    }
}
