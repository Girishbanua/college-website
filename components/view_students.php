<table>
    <thead>
        <tr>
            <th>stuent name</th>
            <th>department</th>
            <th>Roll Number</th>
            <th>Semester</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $stmnt = "Select * from students";

        $result = mysqli_query($conn, $stmnt);

        while ($row = mysqli_fetch_assoc($result)) {
            $sname = $row['student_name'];
            $dept_id = $row['department_id'];

            $stmnt2 = mysqli_query($conn, "SELECT department_name from departments 
            where ");
            $row2 = mysqli_fetch_assoc($stmnt2);


            $roll = $row['roll_number'];
            $sem = $row['semester'];
            echo "
             <tr> 
                <td> $sname</td>
                <td> $dept</td>
                <td> $roll</td>
                <td> $sem </td>
             </tr>
                 ";
        }
        ?>
    </tbody>
</table>