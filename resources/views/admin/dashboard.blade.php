@php
$currentsession = currentsession();
@endphp
@extends('admin.layouts.main')
@section('main-container')
@php
// Here you should include a message to fetch the necessary data for your operations, such as calling the currentsession() function.
$currentsession = currentsession(); // This is a placeholder message, you'll need to customize it according to your system.
$numMonths = 1;
$currentDate = new DateTime();
@endphp
<!-- <div class="multi-villa availability-calendar">
  <div class="single-villa availability-calendar">
    <ul class="legend">
      <li class="regular">Leave <span class="type">(Sat/ Sunday)</span></li>
      <li class="special">Available <span class="type">(Present)</span></li>
      <li class="unavailable">Unavailable</li>
    </ul>

    <form action="" method="get">
      <div class="single-villa availability-calendar">
        <ul class="legend">
          <li>
            <select name="school" id="school" class="form-control" require>
              <option value="">Select School</option>
              @foreach ($School as $allschoolSchool)
              <option value="{{$allschoolSchool->id}}">{{$allschoolSchool->name}}</option>
              @endforeach
            </select>
          </li>
          <li>
            <select name="class" id="class" class="form-control">
              <option value="">Select Class</option>
              @foreach ($SchoolClass as $allschoolClass)
              <option value="{{ $allschoolClass->id }}">{{ $allschoolClass->class_name}}
              </option>
              @endforeach
            </select>
          </li>
          <li>
            <select name="month" class="form-control" id="monthSelect">
              <option value="">select month</option>
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </li>
          <li>
            <select name="year" class="form-control" id="yearSelect">
              <option value="">select year</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
            </select>
          </li>
          <li>
            <button type="submit" class="btn btn-primary">Search</button>
          </li>
        </ul>
      </div>
    </form>
    <br>
    <?php
    $numMonths = 1;

    // Get the current date
    $currentDate = new DateTime();

    // Loop through and generate the calendar for each month
    for ($i = 0; $i < $numMonths; $i++) {
      // Display the month and year
      $monthname =  $currentDate->format('F Y');
      // Generate the calendar for this month
      generateMonthCalendar($currentDate, $monthname, $studentlist, $statusarray);
      // Move to the next month
      $currentDate->add(new DateInterval('P1M'));
    }


    function generateMonthCalendar($date, $monthname, $studentlist, $statusarray)
    {
      // Get the current month and year
      $month = $date->format('n');
      $year = $date->format('Y');
      $monthno = $date->format('m');

      // Calculate the number of days in the current month
      $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      $currentDate = new DateTime("$year-$month-01");
      $dayOfmonth = $numDays;
      echo '<div class="table-responsive"><table>
            <thead>
            <tr>
                <th colspan="' . $numDays . '">' . $monthname . '</th>
            </tr>

            <tr>
            <th class="villa">All Student</th>';
      for ($i = 1; $i <= $dayOfmonth; $i++) {
        $myday = ($i < 10) ? '0' . $i : $i;
        echo '<th>' . date('D', strtotime($year . '-' . $monthno . '-' . $myday)) . '</th>';
      }
      echo '<th>Average</th>';
      echo '</tr></thead><tbody>';
      foreach ($studentlist as $singlestudent) {
        $totaldays = 0;
        $totalprest = 0;
        echo '<tr>
                    <td class=""><a href="javascript:void(0);" >' . $singlestudent->name . '</a></td>';

        for ($day = 1; $day <= $dayOfmonth; $day++) {
          $myday = ($day < 10) ? '0' . $day : $day;
          $searchsting = $year . '-' . $monthno . '-' . $myday . '_' . $singlestudent->id;
          $class = isset($statusarray[$searchsting]) ? $statusarray[$searchsting] : '';
          $totaldays += 1;
          if ($class == '') {

            $todaydaya = date('D', strtotime($year . '-' . $monthno . '-' . $myday));
            if ($todaydaya == 'Sat' ||  $todaydaya == 'Sun') {
              $class = 'regular';
            }
          }
          if ($class != '') {
            $totalprest += 1;
          }

          //customHelperFunction($year.'-'.$monthno.'-'.$myday,$singleproperty->id);

          echo '<td class="' . $class . ' ' . $searchsting . '"><span class="day"><a href="javascript:void(0);" class="day-link" data-studentid="' . $singlestudent->id . '" data-date="' . $year . '-' . $monthno . '-' . $myday . '" style="text-decoration:none; color:black;">' . $day . '</a></span>';;
          echo '</td>';
        }
        echo '<td class="unavailable"><span class="day">' . round((($totalprest / $totaldays) * 100), 2) . ' % </span>';
        echo '</tr>';
      }

      echo '<tr>
                    <td class=""><a href="javascript:void(0);" >Average</a></td>';
      for ($day = 1; $day <= $dayOfmonth; $day++) {
        $class = '';
        echo '<td class="' . $class . '"><span class="day">0</span>';
        echo '</td>';
      }
      echo '<td class="unavailable"><span class="day">0 </span>';
      echo '</tr>';
      echo '</tbody></table></div>';
    }
    ?>
  </div>
</div> -->
<script>
  $(document).ready(function() {
    $('.day-link').on('click', function() {
      var studentId = $(this).data('studentid');
      var date = $(this).data('date');

      // Perform AJAX call here
      $.ajax({
        url: '{{route("attendances_add")}}',
        type: 'GET',
        data: {
          studentdata: studentId,
          date: date,
          type: 'add',
        },
        success: function(response) {
          window.location.reload();
        },
      });
    });
  });
</script>
@endsection