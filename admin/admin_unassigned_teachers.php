<?php
include_once '../db_config.php';

if (isset($_GET['action'])) {

    if (filter_input(INPUT_GET, 'action') == 'delete-teacher') {

        $student_id = filter_input(INPUT_GET, 'teacher-id');

        $student_update_sql = "UPDATE `teachers` SET `status`=3 WHERE `teacher_id`='$student_id'";

        $student_update_query_result = $db_connection->query($student_update_sql);

        if ($student_update_query_result == 1) {

            //Update Success
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=success");
            exit();

        } else {

            //Update Failure
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=failure");
            exit();
        }
    }
    if (filter_input(INPUT_GET, 'action') == 'suspend-teacher') {

        $student_id = filter_input(INPUT_GET, 'teacher-id');

        $student_update_sql = "UPDATE `teachers` SET `status`=2 WHERE `teacher_id`='$student_id'";

        $student_update_query_result = $db_connection->query($student_update_sql);

        if ($student_update_query_result == 1) {

            //Update Success
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=success2");
            exit();

        } else {

            //Update Failure
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=failure2");
            exit();
        }
    }
}

$teacher_fetch_sql = "SELECT `teacher_id`, `full_name`, `mobile_number` FROM `teachers` WHERE `status` = 1";
//echo $teacher_fetch_sql;

$teacher_fetch_query_result = $db_connection->query($teacher_fetch_sql);
?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once 'head_for_admin.php';
print_head("Admin", "Unassigned Teachers");
?>

<body>

<section id="container">

    <?php
    include_once 'header.php';
    print_header("admin");

    include_once 'admin_sidebar.php';
    print_sidebar("Teachers", "Unassigned Teachers", $db_connection);
    ?>

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            <?php
            if (isset($_GET['message'])) {

                if (filter_input(INPUT_GET, 'message') == 'success') {

                    echo '<br>
            <div class="alert alert-success"><b>Well done!</b> Teacher Deleted successfully...</div>';

                } elseif (filter_input(INPUT_GET, 'message') == 'failure') {

                    echo '<br>
            <div class="alert alert-danger"><b>Oh snap!</b> Try Again...</div>';
                } else if (filter_input(INPUT_GET, 'message') == 'success2') {

                    echo '<br>
            <div class="alert alert-success"><b>Well done!</b> Teacher Suspended successfully...</div>';

                } elseif (filter_input(INPUT_GET, 'message') == 'failure2') {

                    echo '<br>
            <div class="alert alert-danger"><b>Oh snap!</b> Try Again...</div>';
                }
            }
            ?>

            <h3>Unassigned Teachers</h3>

            <div class="row mt">
                <div class="col-md-12">
                    <div class="content-panel">
                        <table class="table table-striped table-advance table-hover">

                            <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Sl. No.</th>
                                <th><i class="fa fa-bullhorn"></i> Full Name</th>
                                <th><i class="fa fa-bookmark"></i> Mobile Number</th>
                                <th><i class=" fa fa-edit"></i> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            while ($teacher_fetch_query_result_row = mysqli_fetch_assoc($teacher_fetch_query_result)) {

                                $assigned_courses_sql = "SELECT `subjects`.`subject_name`,`streams`.`stream_name`,`courses`.`course_name` FROM `assigns`,`subjects`,`streams`,`courses` WHERE `assigns`.`subject_id`=`subjects`.`subject_id` AND `subjects`.`stream_id`=`streams`.`stream_id` AND `streams`.`course_id`=`courses`.`course_id` AND `teacher_id`='" . $teacher_fetch_query_result_row['teacher_id'] . "'";

                                $assigned_courses_sql_result = $db_connection->query($assigned_courses_sql);

                                if (mysqli_num_rows($assigned_courses_sql_result) == 0) {

                                    echo '<tr>
                                <td>' . $i . '</td>
                                <td><a href="#">' . $teacher_fetch_query_result_row['full_name'] . '</a></td>
                                <td > ' . $teacher_fetch_query_result_row['mobile_number'] . ' </td >
                                <td>
                                    <a href="' . basename($_SERVER["SCRIPT_FILENAME"]) . '?action=suspend-teacher&teacher-id=' . $teacher_fetch_query_result_row['teacher_id'] . '"><button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button></a>
                                    <a href="' . basename($_SERVER["SCRIPT_FILENAME"]) . '?action=delete-teacher&teacher-id=' . $teacher_fetch_query_result_row['teacher_id'] . '"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></a>
                                 </td>
                            </tr > ';
                                    $i++;
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                    </div><!-- /content-panel -->
                </div><!-- /col-md-12 -->
            </div><!-- /row -->

        </section>
        <!-- /wrapper -->
    </section><!-- /MAIN CONTENT -->
    <!--main content end-->

    <?php
    include_once 'footer.php';
    ?>
</section>

<?php
include_once 'scripts.php';
?>

</body>
</html>
