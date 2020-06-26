<?php

include_once '../db_config.php';

if (isset($_GET['action'])) {

    if (filter_input(INPUT_GET, 'action') == 'delete-course') {

        $course_id = filter_input(INPUT_GET, 'course-id');

        $stream_fetch_sql = "SELECT `subject_id` FROM `subjects`,`students` WHERE `subjects`.`stream_id`=`students`.`studying_class` AND `subject_id`='$subject_id'";
        $student_fetch_sql_result = $db_connection->query($stream_fetch_sql);
        if (mysqli_num_rows($student_fetch_sql_result) != 0) {

            //There are students
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=still-students");
            exit();
        }

        $student_update_sql = "UPDATE `students` SET `status`=2,`username`='kkms$random_number',`password`='kkms$random_number' WHERE `student_id`='$course_id'";
//        echo $student_update_sql;

        $student_update_query_result = $db_connection->query($student_update_sql);

        if ($student_update_query_result == 1) {

            //Update Success
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=success&random=$random_number&stream-id=" . $_GET['stream-id'] . "&stream-name=" . $_GET['stream-name']);
            exit();

        } else {

//            echo $db_connection->error;
            //Update Failure
            header("Location: " . basename($_SERVER["SCRIPT_FILENAME"]) . "?message=failure&stream-id=" . $_GET['stream-id'] . "&stream-name=" . $_GET['stream-name']);
            exit();
        }

    }
}

$stream_fetch_sql = "SELECT `course_id`, `course_name` FROM `courses`";

$student_fetch_query_result = $db_connection->query($stream_fetch_sql);
?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once 'head_for_admin.php';
print_head("Admin", "All Courses");
?>

<body>

<section id="container">

    <?php
    include_once 'header.php';
    print_header("admin");

    include_once 'admin_sidebar.php';
    print_sidebar("Courses", "All Courses", $db_connection);
    ?>

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <h3>Current Courses</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="admin_add_course.php">
                                <button class="btn btn-primary btn-block">Add Courses</button>
                            </a>
                        </div>
                    </div>
                </div><!-- /row -->
            </div>

            <div class="row mt">
                <div class="col-md-12">
                    <div class="content-panel">
                        <table class="table table-striped table-advance table-hover">

                            <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Sl. No.</th>
                                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Course Name</th>
                                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($student_fetch_query_result_row = mysqli_fetch_assoc($student_fetch_query_result)) {

                                echo '<tr>
                                <td><a href="#">' . $student_fetch_query_result_row['course_id'] . '</a></td>
                                <td>' . $student_fetch_query_result_row['course_name'] . '</td>
                            </tr>';
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
