<?php
if (isset($_POST['year'])) {
    $calendar = getCalendar((int)$_POST['year']);
    $file = fopen("Calendar" . $_POST['year'] . ".html", "w");
    echo $calendar;

    if ($file) {
        fprintf($file, "%s%s%s",
            "<!doctype html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport'
                              content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                        <link rel='stylesheet' href='style.css'>
                        <title>Calendar</title>
                    </head>
                    <body>", $calendar, "
                    </body>
                    </html>");
    }
    fclose($file);
} else {
    echo "<p style='color: red'>Invalid year</p>";
}

function getCalendar($year): string
{
    $calendar = "<table id='calendar'><tr><th class='calendarTitle' colspan='4'>" . $year . "</th></tr>";
    $year = abs($year);
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

function getMonthString($index): string
{
    switch ($index) {
        case 1:
            return "January";
        case 2:
            return "February";
        case 3:
            return "March";
        case 4:
            return "April";
        case 5:
            return "May";
        case 6:
            return "June";
        case 7:
            return "July";
        case 8:
            return "August";
        case 9:
            return "September";
        case 10:
            return "October";
        case 11:
            return "November";
        case 12:
            return "December";
    }
    return "UNKNOWN";
}

function calcDaysInMonth($month, $year) {
    $dayCountInMonth = array(31, 28, 31, 30,
        31, 30, 31, 31,
        30, 31, 30, 31);
    return $dayCountInMonth[$month - 1] + ($month == 2 && (($year) % 4 == 0) - (($year) % 100 == 0) + (($year) % 400 == 0));
}

function getMonthTable($year, $month): string
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

    $prevMonthDayCount = calcDaysInMonth(
        ($month - 2 + 12) % 12 + 1,
        $year - ($month == 1));
    $startDay = (date("w", mktime(0, 0, 0, $month, 1, $year)) - 1 + 7) % 7;
    $dayCount = calcDaysInMonth($month, $year);

    $prevMonthDate = $prevMonthDayCount - $startDay + 1;

    $cellCount = 0;
    $monthTable = $monthTable . "<tr>";
    for ($i = 1; $i <= $startDay; $i++) {
        $monthTable = $monthTable . "<td class='otherMonth'>" . $prevMonthDate++ . "</td>";
        $cellCount++;
    }

    $currentDay = 1;
    while ($dayCount > 0) {
        if ($i % 7 == 1) {
            $monthTable = $monthTable . "<tr>";
        }

        $monthTable = $monthTable . "<td " . (isHoliday($month, $currentDay) ? "class='holiday'" : " ") . ">" . $currentDay++ . "</td>";

        if ($i % 7 == 0) {
            $monthTable = $monthTable . "</tr>";
        }
        $i++;
        $dayCount--;
        $cellCount++;
    }

    $currentDay = 1;
    while ($cellCount < 42) {
        if ($i % 7 == 1) {
            $monthTable = $monthTable . "<tr>";
        }

        $monthTable = $monthTable . "<td class='otherMonth'>" . $currentDay++ . "</td>";

        if ($i % 7 == 0) {
            $monthTable = $monthTable . "</tr>";
        }
        $i++;
        $cellCount++;
    }

    return $monthTable . "</table>";
}

function isHoliday($month, $day): bool
{
    $holidays = [
        [1, 1, 7],
        [3, 8],
        [5, 1, 9],
        [7, 3],
        [11, 7],
        [12, 25]
    ];
    for ($i = 0; $i < count($holidays); $i++) {
        if ($month == $holidays[$i][0]) {
            for ($j = 1; $j < count($holidays); $j++) {
                if ($day == $holidays[$i][$j]) return true;
            }
            return false;
        }
    }
    return false;
}