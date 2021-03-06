<?php
    require_once("config.php");
	/**
     * Connects to the database
     *
     * @return link - the link to the database.
    */
	function connect() {		
		$link = mysqli_connect($GLOBALS["config"]["database"]["host"],
                               $GLOBALS["config"]["database"]["user"],
                               $GLOBALS["config"]["database"]["passwd"],
                               $GLOBALS["config"]["database"]["db"]);

		if (!$link) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		} else {
			// echo "SUCCESS";
		}
		
		return $link;	
	}

	function get_result( $Statement ) {
	    $RESULT = array();
	    $Statement->store_result();
	    for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
	        $Metadata = $Statement->result_metadata();
	        $PARAMS = array();
	        while ( $Field = $Metadata->fetch_field() ) {
	            $PARAMS[] = &$RESULT[ $i ][ $Field->name ];
	        }
	        call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
	        $Statement->fetch();
	    }
	    return $RESULT;
	}
	/**
     * Executes the query
     *
     * @param sql - query that needs to be executed.
     * @return result - data retrieved from database.
    */
	function query($sql) {
		$link = connect();
		
		
		$result = mysqli_query($link, $sql);

		close($link);

		return $result;
	}
	
	/**
     * Gets the number of rows of data.
     *
     * @param sql - query that needs to be executed.
     * @return result - Number of rows.
    */
	function num_rows($sql) {
		$link = connect();

		$result = mysqli_num_rows($sql);

		close($link);
		return $result;
	}

	/**
     * Disconnects from the database.
     *
     * @param link - the link to the database.
    */
	function close($link) {
		mysqli_close($link);
	}	
?>
