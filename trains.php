<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chicago Transit Authority</title>

  <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Chicago_Transit_Authority_Logo.svg/1920px-Chicago_Transit_Authority_Logo.svg.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">


    <header>

    <h1>Departures</h1>

    <form action="#" method="post" enctype="multipart/form-data" id="csvForm">
    <label for="csvFile">Select a CSV file:</label>
    <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
    <button type="submit">Upload CSV</button> </form>

    </header>


  <style>

    body {
      font-family: 'Arial', sans-serif;
      background-color: black;
      color: whitesmoke;
    }

    table {
      width: 100%;
      font-family: 'Press Start 2P';
      border-collapse: collapse;
      margin-top: 20px;
      color: orange; 
    }

    /* table head, table data, table row*/
    th, td {
      border: 1px solid yellow; 
      padding: 10px;
      text-align: left;
      
    }

    th {
      background-color: #333333;
    }

  </style>

</head>


<?php

/* Coding interview for Yan Los. Notes:

    I am assuming in the .csv file that one of the "route names" is supposed to be missing, might matter for sorting. 
    Spent 30 minutes setting up my environment , about 45 minutes writing to upload / ask user input and then 30 to sort method
    Spent 30 minutes styling it to look like a billboard. So around 3 hours total. 

    If I were to spend more time I would add the CRUD methods using user inputs. I would also 


*/
function readAndSortCSV($csvFile) {
    $csvData = [];
    $uniqueWords = [];

    if (($open = fopen($csvFile, 'r')) !== FALSE) {
        // skip the title, open csv file 
        fgetcsv($open, 0, ',');

        while (($data = fgetcsv($open, 0, ',')) !== FALSE) {
            $word = implode('', $data); // adding all the words together in order to make one phrase
            // echo $word;
            // echo "<br>";
            // check if the created phrase is unique
            if (!in_array($word, $uniqueWords)) {
                $csvData[] = $data;
                $uniqueWords[] = $word; 
            }
        }

        fclose($open);

        // sort based on the "Run Number", compare strings and then numbers 
        usort($csvData, function($a, $b) {
            return strcmp($a[2], $b[2]); // hard coding it to the the third column
        });

        return $csvData;
    } else {
        echo 'Error: Unable to open the CSV file.';
        return -1;
    }
}

function displayDataInTable($data) {
    echo '<table>';
    echo '<tr><th>Train Line</th><th>Route Name</th><th>Run Number</th><th>Operator ID</th></tr>';

    // display the data we sorted earlier to the table 
    foreach ($data as $row) {
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }

}

// Main function, we check to see if we have a file in 
if (isset($_FILES['csvFile'])) {
    $sortedData = readAndSortCSV($_FILES['csvFile']['tmp_name']);

    if ($sortedData !== -1) {
        displayDataInTable($sortedData);
    }
}
else{
    echo "Please click on 'Choose File' and add your .csv file and then press 'Upload CSV'";
}
?>


</body>
</html>
