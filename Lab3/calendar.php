<?php
if (isset($_POST['year']) && isValidYear($_POST['year'])) {
    echo getCalendar((int)$_POST['year']);
} else {
    echo "<p style='color: red'>Invalid year</p>";
}

function isValidYear($year): bool
{
    if ($year >= 1970 && $year <= 2021) return true;
    return false;
}

function getCalendar($year): string
{
    $calendar = "<table id='calendar'><tr><th class='calendarTitle' colspan='4'>" . $year . "</th></tr>";
    for ($month = 1; $month < 13; $month++) {
        if ($month % 4 == 1) {
            $calendar = $calendar . "<tr>";
        }

        $calendar = $calendar . "<td>" . getMonthTable($year, $month) . "</td>";

        if ($month % 4 == 0) {
            $calendar = $calendar . "</tr>";
        }
    }

    return $calendar . "</table>";
}

function getMonthString($index):string
{
    switch ($index)
    {
        case 1: return "January";
        case 2: return "February";
        case 3: return "March";
        case 4: return "April";
        case 5: return "May";
        case 6: return "June";
        case 7: return "July";
        case 8: return "August";
        case 9: return "September";
        case 10: return "October";
        case 11: return "November";
        case 12: return "December";
    }
    return "UNKNOWN";
}

$stringMonth = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

function getMonthTable($year, $month):string
{
    $monthTable = "<table class='oneMonth'><tr><th class='monthTitle' colspan='7'>" . getMonthString($month) . "</th></tr>
        <tr>
            <th>Mn</th>
            <th>Tu</th>
            <th>Wd</th>
            <th>Th</th>
            <th>Fr</th>
            <th>Sa</th>
            <th>Sn</th>
        </tr>";

    $prevMonthDayCount = cal_days_in_month(CAL_GREGORIAN,
        ($month - 2 + 12) % 12 + 1,
        $year - ($year > 1970 && $month == 1));
    $startDay = (date("w", mktime(0,0,0, $month, 1, $year)) - 1 + 7) % 7;
    $dayCount = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $prevMonthDate = $prevMonthDayCount - $startDay + 1;

    $cellCount = 0;
    $monthTable = $monthTable . "<tr>";
    for($i = 1; $i <= $startDay; $i++) {
        $monthTable = $monthTable . "<td class='otherMonth'>" . $prevMonthDate++ . "</td>";
        $cellCount++;
    }

    $currentDay = 1;
    while($dayCount > 0) {
        if($i % 7 == 1) {
            $monthTable = $monthTable . "<tr>";
        }

        $monthTable = $monthTable . "<td>" . $currentDay++ . "</td>";

        if($i % 7 == 0) {
            $monthTable = $monthTable . "</tr>";
        }
        $i++;
        $dayCount--;
        $cellCount++;
    }

    $currentDay = 1;
    while($cellCount < 42) {
        if($i % 7 == 1) {
            $monthTable = $monthTable . "<tr>";
        }

        $monthTable = $monthTable . "<td class='otherMonth'>" . $currentDay++ . "</td>";

        if($i % 7 == 0) {
            $monthTable = $monthTable . "</tr>";
        }
        $i++;
        $cellCount++;
    }

    return $monthTable . "</table>";
}