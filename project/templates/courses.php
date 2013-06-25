<div class="row">
  <div class="<?php echo (is_student() ? 'span12': 'span9'); ?>">
    <h3>Courses taken by term</h3>
    <table class="table table-hover">
      <?php

        $courses_per_term = Course::get_courses_by( 'term', $_SESSION['viewing_psid'] );

        if ( !empty($courses_per_term) ) {

          ksort( $courses_per_term );
          foreach( $courses_per_term as $term => $courses ) {
          ?>

            <tr>
              <td>
                <?php echo $term; ?>
              </td>
              <td>

                <?php
                
                foreach( $courses as $course ) {
                  $course->print_with_grade();
                  echo "<br>";
                }

                ?>

              </td>
            </tr>

          <?php
            } // foreach $courses_per_term
          } else {
            echo "No courses taken.";
          }
        ?>
    </table>
  </div>
</div>

<br>

<div class="row">
  <div class="<?php echo (is_student() ? 'span12': 'span9'); ?>">
    <h3>Courses taken by department</h3>
     <table class="table table-hover">
      <?php

        $courses_by_department = Course::get_courses_by( 'department', $_SESSION['viewing_psid'] );

        if ( !empty($courses_by_department) ) {


          ksort( $courses_by_department );
          foreach( $courses_by_department as $department => $courses ) {
            ?>

            <tr>
              <td>
                <?php echo $department; ?>
              </td>
              <td>
                <?php
                
                foreach( $courses as $course ) {
                  echo $course->get_with_grade();
                  echo "<br>";
                }

                ?>

              </td>
            <?php
          } // foreach $courses_by_department
        } else {
          echo "No courses taken.";
        }
      ?>
    </table>
  </div>
</div>

<br>  

<div class="row">
  <div class="<?php echo (is_student() ? 'span12': 'span9'); ?>">
    <h3>CS graduation requirements</h3>
    <table class="table table-hover">

    <?php

        $reqs = Requirement::find_all();

        ksort( $reqs );
        foreach( $reqs as $req ) {
        ?>
          <tr>  
            <td>
              <?php echo $req->title; ?>
            </td>

            <td>
              <?php
              
                if ( $req->is_satisfied( $_SESSION['viewing_psid'], $req ) ) {

              ?>

                <span class='text-success'>S</span>

              <?php

                } else { 

              ?>
                <span class='text-error'>N</span>
            
              <?php } ?>
            </td>
            <td>
          
            <?php
            /*
              if ( $req->is_satisfied( $_SESSION['viewing_psid'], $req ) ) {
                $req->print_satisfying_course( $_SESSION['viewing_psid'], $_SESSION['user_courses'] );
              } else {
                echo "<span class='muted'>Courses that satisfy this requirement: ";
                $req->print_requirements();
                echo "</span>";
              }*/
            ?>

            </td>
          </tr>

          
          <?php
          
          } // foreach $reqs

        ?>
    </table>
    
  </div>
</div>