<div class="row">
  <div class="<?php echo (is_student() ? 'span12': 'span9'); ?>">
    <h3>Courses taken by term</h3>
    <table class="table table-hover">
      <?php

        $courses_per_term = UserCourse::find_by( 'term', $_SESSION['viewing_psid'] );

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
                
                foreach( $courses as $course )
                  echo "$course<br>";

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

        $courses_by_department = UserCourse::find_by( 'department', $_SESSION['viewing_psid'] );

        if ( !empty($courses_by_department) ) {

          asort( $courses_by_department ); // TODO - this may be tricky
          foreach( $courses_by_department as $department => $courses ) {
            ?>

            <tr>
              <td>
                <?php echo $department; ?>
              </td>
              <td>
                <?php
                
                foreach( $courses as $course )
                  echo "$course<br>";

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
            <td><?php echo $req->title; ?></td>
            <td>
              <?php
              
                if ( $course = $req->get_satisfying_course( $_SESSION['viewing_psid'] ) ) {

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
            
              if ( $course ) {
                echo $course;
              } else {
                echo "<span class='muted'>Courses that satisfy this requirement: ";
                $req->print_requirements();
                echo "</span>";
              }
            ?>

            </td>
          </tr>

          
          <?php
          
          } // foreach $reqs

        ?>
    </table>
    
  </div>
</div>