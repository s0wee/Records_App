<?php

require ('vendor/autoload.php');

$faker = Faker\Factory::Create('en_PH');

$host = "localhost";
$dbname = "employee_data";
$username = "root";
$password = "rejaas070300";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    'Connection Failed: ' . die(mysqli_connect_error());
}


// function to add data inside the employee table
function addEmpData(int $limit, $conn): void{
  global $faker;

  for ($i = 0; $i < $limit; $i++){
    $lastname = $faker->lastName();
    $firstname = $faker->firstName();
    $officeid = $faker->numberBetween(1, 50);
    $address = $faker->address();

    $stmt = $conn -> prepare("INSERT INTO employee_data.employee(last_name, first_name, office_id, address) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssis", $lastname, $firstname, $officeid, $address);

        if ($stmt -> execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        echo "\n";
  }
}

// funtion to add data inside the office table
function addOffData(int $limit, $conn):void{
  global $faker;
  for($i = 0; $i < $limit; $i++) {
    $name = $faker->company();
    $contactNum = $faker->phoneNumber();
    $email = $faker->companyEmail();
    $address = $faker->address();
    $city = $faker->city();
    $country = $faker->country();
    $postal = $faker->postcode();

    $stmt = $conn -> prepare("INSERT INTO employee_data.office(name, contact_number, email, address, city, country, postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("sssssss", $name, $contactNum, $email, $address, $city, $country, $postal);

    if ($stmt -> execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    echo "\n";
}
}


// funtion to add data inside the transaction table
function addTransdata(int $limit, $conn):void{
  global $faker;
  for($i = 0; $i < $limit; $i++) {
    $employeeId = $faker->numberBetween(1, 200);
    $officeId = $faker->numberBetween(1, 50);
    $date = $faker->date();
    $action = $faker->randomElement(array('Cash Payment', 'Loan', 'Loan Payment', 'Order Purchase'));
    $remarks = $faker->optional()->word();
    $documentCode = $faker->countryCode();

    $stmt = $conn -> prepare("INSERT INTO employee_data.transaction(employee_id, office_id, datelog, action, remarks, documentcode)
                                        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("iissss", $employeeId, $officeId, $date, $action, $remarks, $documentCode);
    $stmt -> execute();

    if ($stmt -> execute()) {
      echo "New record created successfully";
  } else {
      echo "Error: " . mysqli_error($conn);
  }
  echo "\n";
}
}

// calling the adding data methods to populate the created table
addEmpData(200, $conn);
addOffData(50, $conn);
addTransdata(500, $conn);

?>