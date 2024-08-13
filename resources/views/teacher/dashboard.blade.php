@extends('teacher.layouts.main')
@section('main-container')
@php
$currentsession = currentsession();
$numMonths = 1;
$currentDate = new DateTime();
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style type="text/css">
    .availability-calendar td.regular .day {
        align-items: center;
        width: 100%;
        position: unset;
        height: 100%;
        display: flex;
        justify-content: center;
    }

    .availability-calendar td.regular {
        text-align: center;
    }

    .availability-calendar {
        clear: both
    }

    .availability-calendar table {
        display: inline-block !important;
        margin-bottom: 28px;
        border-collapse: collapse !important;
        vertical-align: top
    }

    .availability-calendar table thead {
        background: transparent !important;
        color: #222 !important
    }

    .availability-calendar table th {
        border: 0 !important;
        padding: 8px 5px;
        font-size: 12px;
    }

    .availability-calendar table td {
        border: 0 !important;
        padding: 0 !important;
        min-width: 27px;
        width: 32px;
        height: 32px
    }

    .availability-calendar table td .day {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 1;
        font-size: 12px
    }

    .availability-calendar .legend {
        margin: 0 0 32px 0;
        padding: 0;
        font-size: 12px;
        text-align: center;
        list-style: none
    }

    .availability-calendar .legend:last-child {
        margin: 0
    }

    .availability-calendar .legend li {
        display: inline-block;
        margin: 0 10px 10px 0px;
        padding-left: 35px;
        line-height: 16px;
        text-align: left;
        font-size: 10px;
        vertical-align: top
    }

    .availability-calendar .legend li:last-child {
        margin-right: 0
    }

    .availability-calendar .legend li.unavailable {
        line-height: 30px
    }

    .availability-calendar .legend li:after {
        content: ""
    }

    .availability-calendar .legend li .type {
        display: block
    }

    .availability-calendar table td,
    .availability-calendar .legend li {
        position: relative
    }

    .availability-calendar table td:after,
    .availability-calendar .legend li:after {
        position: absolute;
        top: 0;
        left: 0;
        border-top: 32px solid transparent;
        border-right: 34px solid transparent;
        /*    right: 0px;*/
    }

    .availability-calendar table td:after {
        right: 0;
    }

    .availability-calendar td.unavailable,
    .availability-calendar td.unavailable-am,
    .availability-calendar td.unavailable-pm,
    .availability-calendar li.unavailable:after {
        background-color: #f27a75
    }

    .availability-calendar td.regular,
    .availability-calendar li.regular:after {
        background-color: #d1d1d1   
    }

    .availability-calendar td.special,
    .availability-calendar li.special:after {
        background-color: #1b9405
    }

    .availability-calendar .regular-am:after {
        border-top-color: #f4f4f4 !important;
        content: ""
    }

    .availability-calendar .regular-pm:after {
        border-right-color: #f4f4f4 !important;
        content: ""
    }

    .availability-calendar .special-am:after {
        border-top-color: #8fd66b !important;
        content: ""
    }

    .availability-calendar .special-pm:after {
        border-right-color: #8fd66b !important;
        content: ""
    }

    .single-villa.availability-calendar {
        text-align: center
    }

    .multi-villa.availability-calendar {
        text-align: left
    }

    .multi-villa.availability-calendar table th.villa {
        min-width: 120px;
        width: 152px
    }

    .multi-villa.availability-calendar table tbody td.villa {
        text-align: right !important
    }

    .multi-villa.availability-calendar table tbody td.villa a {
        padding-right: 6px;
        color: #0d6f3e !important;
        text-decoration: none !important
    }

    .multi-villa.availability-calendar table tbody tr:hover td.villa {
        background-color: #0d6f3e;
        color: #fff
    }

    .multi-villa.availability-calendar table tbody tr:hover td.villa a {
        color: #fff !important
    }

    @media only screen and (min-width: 485px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 0
        }
    }

    @media only screen and (min-width: 490px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 5px
        }
    }

    @media only screen and (min-width: 500px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 15px
        }
    }

    @media only screen and (min-width: 510px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 25px
        }
    }

    @media only screen and (min-width: 520px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 35px
        }
    }

    @media only screen and (min-width: 715px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 0
        }
    }

    @media only screen and (min-width: 725px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 5px;
            margin-right: 5px
        }
    }

    @media only screen and (min-width: 745px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 15px;
            margin-right: 15px
        }
    }

    @media only screen and (min-width: 765px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 25px;
            margin-right: 25px
        }
    }

    @media only screen and (min-width: 785px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 35px;
            margin-right: 35px
        }
    }

    @media only screen and (min-width: 940px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 0;
            margin-right: 0
        }

        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 35px
        }
    }

    @media only screen and (min-width: 1080px) {
        #page-content .single-villa.availability-calendar table:nth-child(odd) {
            margin-left: 0
        }
    }

    @media only screen and (min-width: 1095px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 5px;
            margin-right: 5px
        }
    }

    @media only screen and (min-width: 1130px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 15px;
            margin-right: 15px
        }
    }

    @media only screen and (min-width: 1160px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 25px;
            margin-right: 25px
        }
    }

    @media only screen and (min-width: 1190px) {
        #page-content .single-villa.availability-calendar table:nth-child(3n) {
            margin-left: 35px;
            margin-right: 35px
        }
    }

    @media only screen and (min-width: 800px) {
        .multi-villa.availability-calendar table tbody td.villa {
            -webkit-transition: all 0.3s ease-in-out 0s;
            -moz-transition: all 0.3s ease-in-out 0s;
            -o-transition: all 0.3s ease-in-out 0s;
            transition: all 0.3s ease-in-out 0s
        }
    }

    .availability-calendar table td a {
        color: #0d6f3e;
        width: 100%;
        display: block;
        text-transform: uppercase;
        font-size: 12px;
    }
</style>
<div class="multi-villa availability-calendar">


    <head>
        <title>Student Attendance</title>
        <style>
        </style>
    </head>
<form action="" method="get" id="searchForm">
    <div class="single-villa availability-calendar">
        <ul class="legend">
            <li>
                <select name="classes" class="form-control selectedclass" id="selectClass">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                    <option value="{{$class->id}}" {{request('classes')==$class->id ? 'selected':''}} {{(!empty($choosed)&&$class->id==$choosed)?'selected':''}}>{{$class->class_name}}</option>
                    @endforeach
                </select>
        </li>
        <li>
            <a href="{{route('teacher.dashboard')}}" type="reset" class="btn btn-success">Reset</a>
        </li>
        <li><p class="card-title"><a href="{{route('studentadd')}}" class="btn btn-primary">Add Student</a></p></li>
        <li><p class="card-title"><a class="btn btn-primary" href="{{route('classindex')}}">Class</a></p></li>
        </form>
            
        </ul>

        <ul class="legend">
        <li class="regular">Leave <span class="type">(Sat/ Sunday)</span></li>
            <li class="special">Available <span class="type">(Present)</span></li>
        </ul>

        <?php

        $numMonths = 1;
        $currentDate = new DateTime();
        for ($i = 0; $i < $numMonths; $i++) {

            $dateArray = [];

            $currentWeekday = (int)$currentDate->format('w');
            if ($currentWeekday == 0) {
                $startDate = $currentDate;
                $endDate = (clone $startDate)->modify('+20 days');
            } else {
                $endDate = $currentDate->modify('last Sunday'); 
                $startDate = (clone $endDate)->modify('-27 days');
            }
            $startTimeStamp = $startDate->getTimestamp();
            $endTimeStamp = $endDate->getTimestamp();
            $currentTimeStamp = $startTimeStamp;
            while ($currentTimeStamp <= $endTimeStamp) {
                $currentDate = new DateTime('@' . $currentTimeStamp);
                $formattedDate = $currentDate->format('Y-m-d');
                $dateArray[] = $formattedDate;
                $currentTimeStamp += 86400;
            }     
            $monthname =  $calendardate->format('F Y');
            generateMonthCalendar($dateArray, $monthname, $studentlist, $statusarray);
            $currentDate->add(new DateInterval('P1M'));
        }

        function generateMonthCalendar($date, $monthname, $studentlist, $statusarray)
        {
            $numDays = count($date);
            $weekarray = array();
            echo '<div class="table-responsive"><table>
            <thead>
            <tr>
                <th colspan="' . $numDays . '">' . $monthname . '</th>
            </tr>

            <tr>
            <th class="villa">All Student</th>';
            $weekdate = array();
            $weekdayscount = array();
            foreach ($date as $singledate) {
                echo '<th>' . date('D', strtotime($singledate)) .'<br>'.date('d', strtotime($singledate)). '</th>';
                $weekdate[$singledate] = date("W", strtotime($singledate));
                if(!isset($weekdayscount[date("W", strtotime($singledate))])){
                    $weekdayscount[date("W", strtotime($singledate))] = 0;
                }
                $weekdayscount[date("W", strtotime($singledate))] += 1;
            }
            echo '</tr></thead><tbody>';
            $weekattendacnearray = array();
            $weektotalattendacne = array();
            foreach ($studentlist as $singlestudent) {
                $totaldays = 0;
                $totalprest = 0;
                echo '<tr>
                    <td class=""><a href="javascript:void(0);" >' . $singlestudent->name . '</a></td>';
                foreach($date as $key => $day){
                    $searchsting =  $day . '_' . $singlestudent->id;
                    $class = isset($statusarray[$searchsting]) ? $statusarray[$searchsting] : '';
                    $totaldays += 1;
                    $icon = '<i class="fas fa-recycle"></i>';
                    if(!isset($weekattendacnearray[$weekdate[$day]])){
                            $weekattendacnearray[$weekdate[$day]] = 0;
                        }

                    if(!isset($weektotalattendacne[$weekdate[$day]])){
                            $weektotalattendacne[$weekdate[$day]] = 0;
                        }

                    if ($class != '') {
                         $weekattendacnearray[$weekdate[$day]] += 1;
                        $icon = '<i class="fas fa-recycle"></i>';
                        $totalprest += 1;
                    }
                    $todaydaya = date('D', strtotime($day));
                    if ($class == '') {
                        
                        if ($todaydaya == 'Sat' ||  $todaydaya == 'Sun') {
                            $class = 'regular';
                            $icon = '<i class="fas fa-lock"></i>';
                        }
                    }
                    if ($todaydaya == 'Sat' ||  $todaydaya == 'Sun') {

                    }else{
                        $weektotalattendacne[$weekdate[$day]] += 1;
                    }


                    echo '<td class="' . $class . ' ' . $searchsting . '"><span class="day"><a href="javascript:void(0);" class="day-link" data-studentid="' . $singlestudent->id . '" data-date="'.$day. '" style="text-decoration:none; color:black;">' . $icon . '</a></span></td>';
                }
                echo '</tr>';
            }

            echo '<tr>
                    <th class=""><a href="javascript:void(0);">Average</a></th>';
                    $weektotalattendacne = array_values($weektotalattendacne);
                    $weekattendacnearray = array_values($weekattendacnearray);
                    $weekdayscount = array_values($weekdayscount);
                    $stratkey = 0;
                    foreach($weekdayscount as $stratkey=>$weekd){
                            echo '<th colspan="'.$weekd.'"><span class="day">'. round((($weekattendacnearray[$stratkey] / $weektotalattendacne[$stratkey]) * 100), 2) .'%</span></th>';
                    }
            echo '</tr>';
            echo '</tbody></table></div>';
          

        }
        ?>


    </div>
</div>
<script>
  $(document).ready(function() {
    $('.selectedclass').on('change', function() {
        $("#searchForm").submit();
    });
});
    $(document).ready(function() {
        // var currentMonth = new Date().getMonth() + 1;
        // var currentYear = new Date().getFullYear();
        // document.getElementById("monthSelect").value = currentMonth.toString().padStart(2, '0');
        // document.getElementById("yearSelect").value = currentYear.toString();
        $('.day-link').on('click', function() {
            var studentId = $(this).data('studentid');
            var date = $(this).data('date');
            $.ajax({
                url: '{{route("attendances_add")}}',
                type: 'GET',
                data: {
                    studentdata: studentId,
                    date: date,
                },
                success: function(response) {
                    window.location.reload();
                },
            });
        });
    });

</script>

@endsection