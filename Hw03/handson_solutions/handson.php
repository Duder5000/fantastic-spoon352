<?php

// ----------- TASK 1 ----------- //

// Import the db configuration file here and create a connection to the DB
// Make sure the connection is successfully established, otherwise stop processing the rest of the script.
require("data/db.php");

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


// Test if connection succeeded
if(mysqli_connect_errno()) {
  die(mysqli_connect_error()) ;
}

// ----------- END OF TASK 1 ----------- //
?>

<html lang="en">
  <head>
    <title>Databases</title>
    <style>
      td {
        padding-right: 20px;
      }

    </style>
  </head>

  <body>
    <h2>Task 2:</h2>
    <?php
      // ----------- TASK 2 ----------- //

      // Displaying a list of customers’ name in the USA
      // Handle the case where query fails (error in query) and result is empty
      $select_us_customer_query  = "SELECT customerName FROM customers WHERE country='USA' LIMIT 5";

      $select_us_customer_result = mysqli_query($connection, $select_us_customer_query);

      // Test if there was a query error
      if (!$select_us_customer_result) {
        die("Database query failed.");
      }

      if(mysqli_num_rows($select_us_customer_result) != 0) {
        echo "<ul>";
        // while($row= mysqli_fetch_object($select_us_customer_result)) {
        //   echo "<li>" . $row->customerName ."</li>";
        // }
        while($row= mysqli_fetch_assoc($select_us_customer_result)) {
          echo "<li>" . $row['customerName'] ."</li>";
        }
        echo "</ul>";
      } else  {
        echo "<p>The query returned an empty set.</p>";
      }

      mysqli_free_result($select_us_customer_result);

      // ----------- END OF TASK 2 ----------- //
    ?>

    <h2>Task 3:</h2>
    <?php


      // ----------- TASK 3 ----------- //

      // Insert the following data in the database (choose an appropriate table):
        // Customer Number = 247
        // Amount = 432.45
        // Payment Date = 2014-01-2
        // Check Number = abc-002

      // Log the error message if failed.
      $insert_payment_query  = "INSERT INTO payments
                                  (customerNumber, amount, paymentDate, checkNumber)
                                VALUES  (247,
                                        432.45,
                                        '2014-01-02',
                                        'abc-002')";

      if(mysqli_query($connection, $insert_payment_query)) {
        echo "<p>Entry logged with this query: " . $insert_payment_query . "</p>";
      } else {
        echo "<p>Unable to insert new entry due to:</p>";
        echo "<p>" . mysqli_error($connection) . "</p>";
      }

      // ----------- END OF TASK 3 ----------- //

  ?>

  <h2>Task 4</h2>
  <?php

      // ----------- TASK 4 ----------- //

      // Update the amount from task 3 to a different amount
      // Display before and after using two tables using mysqli statements instead of query directly.

      // Log the error message if failed.


      $check_info_query = "SELECT * FROM payments WHERE checkNumber = ?";
      $check_number = 'abc-002';

      // Prepare the query
      $statement = mysqli_prepare($connection, $check_info_query);

      // Check if an error occured while preparing the query
      if(!$statement) {
        die("Error is:". mysqli_error($connection) );
      }

      // Bind the value to avoid injection
      mysqli_stmt_bind_param($statement, 's', $check_number);

      // Excute the query
      mysqli_stmt_execute($statement);

      // Save the result to a mysqli_result object
      $before_result = mysqli_stmt_get_result($statement);

      // Similar to task 1
      if(mysqli_num_rows($before_result) != 0) {
        echo "<h3>Before:</h2>";
        echo "<table>
              <tr>
                <td>customerNumber</td>
                <td>amount</td>
                <td>paymentDate</td>
                <td>checkNumber</td>
              </tr>
              <tr>
              ";

        while($row = mysqli_fetch_assoc($before_result)) {

          echo "<td>" . $row['customerNumber'] ."</td>";
          echo "<td>" . $row['amount'] ."</td>";
          echo "<td>" . $row['paymentDate'] ."</td>";
          echo "<td>" . $row['checkNumber'] ."</td>";
        }
        echo "  </tr>
              </table>";
      } else  {
        echo "<p>The entry cannot be found</p>";
      }

      // free up the result
      mysqli_free_result($before_result);

      // Update query:
      $update_payment_amount_query = "UPDATE payments SET amount='35' WHERE checkNumber='abc-002'";

      mysqli_query($connection, $update_payment_amount_query);


      // After

      // We do not have to recreate a new statment , we can call the bind again
      mysqli_stmt_bind_param($statement, 's', $check_number);

      // Excute the query
      mysqli_stmt_execute($statement);

      $after_result = mysqli_stmt_get_result($statement);

      if(mysqli_num_rows($after_result) != 0) {
        echo "<h3>After:</h2>";
        echo "<table>
              <tr>
                <td>customerNumber</td>
                <td>amount</td>
                <td>paymentDate</td>
                <td>checkNumber</td>
              </tr>
              <tr>
              ";
        while($row= mysqli_fetch_assoc($after_result)) {
          echo "<td>" . $row['customerNumber'] ."</td>";
          echo "<td>" . $row['amount'] ."</td>";
          echo "<td>" . $row['paymentDate'] ."</td>";
          echo "<td>" . $row['checkNumber'] ."</td>";
        }
        echo "  </tr>
              </table>";
      } else  {
        echo "<p>The entry cannot be found</p>";
      }

       // free up the result
      mysqli_free_result($after_result);

      // Close the statement since we are done
      mysqli_stmt_close($statement);

      // ----------- END OF TASK 4 ----------- //
    ?>

    <h2>Task 5:</h2>
    <?php
      // ----------- TASK 5 ----------- //

      // Remove the entries we added in step 3

      $remove_payment_query = "DELETE FROM payments WHERE checkNumber = 'abc-002'";


      mysqli_query($connection, $remove_payment_query);

      echo "<p>Entry deleted the following query: " . $remove_payment_query . "</p>";

      // ----------- END OF TASK 5 ----------- //


    ?>
  </body>
</html>






<?php
  // 5. Close database connection
?>
