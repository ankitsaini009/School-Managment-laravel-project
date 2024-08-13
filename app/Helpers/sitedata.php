<?php
use App\Models\Sitesetting;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\TimeTableConfigartion;



function sitedata()
    {
       $sitedata = Sitesetting::find(1);
       return $sitedata;
    }

    function currentsession(){
      $currentYear = date('Y');
      $currentMonth = date('n');
      // Determine academic year based on the current month
      if ($currentMonth >= 5) {
         // If the current month is August or later, the academic year starts in the current year
         $academicYear = $currentYear . '-' . ($currentYear + 1 - 2000);
      } else {
         // If the current month is before August, the academic year starts in the previous year
         $academicYear = ($currentYear - 1) . '-' . ($currentYear - 2000);
      }

      return $academicYear;
    }

    function getperiodteacher($class_id,$period_id){
      if(TimeTableConfigartion::where('period_id',$period_id)->where('class_id',$class_id)->exists()){

         $configration = TimeTableConfigartion::where('period_id',$period_id)->where('class_id',$class_id)->first();
         $subject = Subject::find($configration->subject_id);
         $teacher = Teacher::find($configration->teacher_id);
         return '<a href="javascript:void(0);" onclick="deleteitem(\'Are You Sure To Delete This Teacher\','.$configration->id.',\''.route('delete.item').'\',\'period_teacher_delete\')"> <h4>'.$teacher->name.'</h4></a><p>'.$subject->subject_name.'</p>';

      }else{
        $button = '<button type="button" periodid="'.$period_id.'" classid="'.$class_id.'"
                                           class="btn btn-info btn-sm asign_teacher">Asign Teacher</button>';
         return $button;
      }
         
    } 