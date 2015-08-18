<?php


/////////////////////////////////////////    CONNECTION    ////////////////////


$cxn = mysqli_connect("127.0.0.1","numberwang","","numberwang") 
		or die ("\nCouldn't connect to server. Please retry.\n\n");

echo "\nDatabase connection successful!\n";


/////////////////////////////////////////    QUERYING    //////////////////////


$query = "


/////////////////////////////////////////    EXECUTE QUERY    /////////////////


$result = mysqli_query($cxn, $query)
			or die ("Couldn't execute query. Please retry.\n\n");

echo "Query executed successfully.\n\n";
