<?php
//اكتشاف عن الطلاب الذين لديهم اكثر من اختبار بنفس اليوم 
$SSD_sql = $connection->query("SELECT * from Examdata join (SELECT Student_ID, count(*), exam_dates FROM Examdata 
group by Student_ID, exam_dates
having count(*) > 1) Examdata1 on Examdata.Student_ID=Examdata1.Student_ID 
and Examdata1.exam_dates=Examdata.exam_dates 
order by Examdata1.Student_ID,Examdata1.exam_dates ;")->fetch_all(MYSQLI_ASSOC);
$student = "";
// طباعة بيانات كل طالب 
foreach ($SSD_sql as $sq) {
    if ($student != $sq["Student_ID"]) {
        $student = $sq["Student_ID"];
        echo '<table id="ssd_student"  class="panel"> 
        <tr>
        <td width="70px">
        <label>
            <input type="submit" class="' . $student . '" onclick="Function();" id="SSD-detiles">
            <img src="images/up-arrow.png"id="img_arrow">
            <br>
        </label>
        </td>';
        echo '<td> Student ID: ' . $sq["Student_ID"] . '</td></tr>';
    }
           // إظهار التفاصيل لكل طالب 
    echo '<tr id="ssd_data" class="'. $student . '" >';
    echo '<td class="myDIV">' . $sq["Class_ID"] . '</td>';
    echo '<td class="myDIV">' . $sq["Subject_ID"] . '</td>';
    echo '<td class="myDIV">' . $sq["Subject_name"] . '</td>';
    echo '<td class="myDIV">' . $sq["lecturer_name"] . '</td>';
    echo '<td class="myDIV">' . $sq["exam_days"] . '</td>';
    echo '<td class="myDIV">' . $sq["exam_dates"] . '</td>';
    echo '<td class="myDIV">' . $sq["exam_times"] . '</td></tr>';
}
?>
</table>

