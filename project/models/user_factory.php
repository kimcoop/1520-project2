<?php

  class UserFactory {

    function create( $record ) {
      return new User( 
        $record[ "$access_level" ],
        $record[ "$email" ],
        $record[ "$first_name" ],
        $record[ "$last_name" ],
        $record[ "$password" ],
        $record[ "$psid" ],
        $record[ "$user_id" ]
      );
    }

    function create_from_file( $line ) {
      $pieces = explode( ":", $line );
      // $quote_line = addslashes(rtrim($quote_line)); TODO
      return new User( 
        $pieces[6], // access
        $pieces[3], // email
        $pieces[5], // first_name
        $pieces[4], // last_name
        $pieces[1], // password
        $pieces[2], // psid
        $pieces[0] // user_id
      );
    }

  }

?>