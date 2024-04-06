<?php
/*
Plugin Name: Student Management Plugin
Description: Plugin for managing student records.
Version: 1.0
Author: Aash Gates (https://aashgates-official.onrender.com/)
*/

// Enqueue Bootstrap CSS
function enqueue_bootstrap_css() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_css');

// Enqueue Bootstrap JS
function enqueue_bootstrap_js() {
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_js');

// Shortcode to display student records
function display_student_records() {
    ob_start(); ?>

    <div class="container">
        <h2>List of Students</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $wpdb;
                $results_per_page = 10;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start_index = ($page - 1) * $results_per_page;

                $sql = "SELECT * FROM StudentRecords LIMIT $start_index, $results_per_page";
                $students = $wpdb->get_results($sql);
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>{$student->student_id}</td>";
                    echo "<td><a href='#' class='student-details' data-toggle='modal' data-target='#studentModal{$student->student_id}'>{$student->full_name}</a></td>";
                    echo "</tr>";

                    // Modal for each student
                    echo "<div class='modal fade' id='studentModal{$student->student_id}' tabindex='-1' role='dialog' aria-labelledby='studentModalLabel{$student->student_id}' aria-hidden='true'>";
                    echo "<div class='modal-dialog' role='document'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='studentModalLabel{$student->student_id}'>Student Details</h5>";
                    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                    echo "<span aria-hidden='true'>&times;</span>";
                    echo "</button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "<p>ID: {$student->student_id}</p>";
                    echo "<p>Full Name: {$student->full_name}</p>";
                    echo "<p>Phone Number: {$student->phone_number}</p>";
                    echo "<p>Date of Birth: {$student->dob}</p>";
                    echo "<p>Mother Tongue: {$student->mother_tongue}</p>";
                    echo "<p>Blood Group: {$student->blood_group}</p>";
                    echo "<p>Known Dust Allergies: {$student->known_dust_allergies}</p>";
                    echo "<p>Mother's Name: {$student->mother_name}</p>";
                    echo "<p>Father's Name: {$student->father_name}</p>";
                    echo "<p>Nationality: {$student->nationality}</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Pagination
        $sql_count = "SELECT COUNT(*) AS total FROM StudentRecords";
        $total_students = $wpdb->get_var($sql_count);
        $num_pages = ceil($total_students / $results_per_page);
        ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $num_pages; $i++) {
                    echo "<li class='page-item" . ($i == $page ? ' active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('display_student_records', 'display_student_records');

