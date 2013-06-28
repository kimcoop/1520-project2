<div class="row">
  <div class="<?php echo (is_student() ? 'span12': 'span9'); ?>">
    <h3>Courses taken by term</h3>
    <table class="table table-hover">
      <?php

        $courses_per_term = UserCourse::find_by( 'term', $student->get_psid() );

        if ( !empty($courses_per_term) ) {
          ksort( $courses_per_term );
          foreach( $courses_per_term as $term => $courses ) {
          ?>
            <tr>
              <td><?php echo $term; ?></td>
              <td><?php foreach( $courses as $course ) echo "$course<br>" ?></td>
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
        $courses_by_department = UserCourse::find_by( 'department', $student->get_psid() );

        if ( !empty($courses_by_department) ):
          foreach( $courses_by_department as $department => $courses ): ?>
            <tr>
              <td><?php echo $department; ?></td>
              <td><?php foreach( $courses as $course ) echo "$course<br>" ?></td>
            </tr>
        <?php
          endforeach;
        else:
          echo "No courses taken.";
        endif;
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
        foreach( $reqs as $index => $req ) {
        ?>
          <tr>  
            <td class="muted"><?php echo $index + 1?></td>
            <td><strong><?php echo $req->title; ?></strong></td>
            <td>
              <?php if ( $course = $req->get_satisfying_course( $student->get_psid() ) ) { ?>
                <span class='text-success'>
                  <i class="icon icon-check"></i>
                </span>
              <?php
                } else { 
              ?>
                <span class='text-error'>
                  <i class="icon icon-check-empty"></i>
                </span>
              <?php } ?>
            </td>
            <td>
          
            <?php
            
              if ( $course ) {
                echo $course;
              } else {
                echo "<span class='muted'>Requirement not satisfied. Course options: ";
                echo $req->get_requirements();
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