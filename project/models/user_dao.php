<?php

  class UserDao extends DAO_Base {

    public function __construct( $db, $table ) {
      parent::__construct( $db, 'users' );
    }

  }

?>