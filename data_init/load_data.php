<?php

require('vendor/autoload.php');

$faker = Faker\Factory::create('en_PH');

$host = "localhost";
$dbname = "employee_data";
$username = "root";
$password = "rejaas070300";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die('Connection Failed: ' . mysqli_connect_error());
}

// Function to add data inside the employee table
function addEmpData($limit, $conn, $faker)
{
    for ($i = 0; $i < $limit; $i++) {
        $lastname = $faker->lastName;
        $firstname = $faker->firstName;
        $officeid = $faker->numberBetween(1, 50);
        $address = $faker->address;

        $stmt = $conn->prepare("INSERT INTO employee(last_name, first_name, office_id, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $lastname, $firstname, $officeid, $address);

        executeStatement($stmt);
    }
}

// Function to add data inside the office table
function addOffData($limit, $conn, $faker)
{
    for ($i = 0; $i < $limit; $i++) {
        $name = $faker->company;
        $contactNum = $faker->phoneNumber;
        $email = $faker->companyEmail;
        $address = $faker->address;
        $city = $faker->city;
        $country = $faker->country;
        $postal = $faker->postcode;

        $stmt = $conn->prepare("INSERT INTO office(name, contact_number, email, address, city, country, postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $contactNum, $email, $address, $city, $country, $postal);

        executeStatement($stmt);
    }
}

// Function to add data inside the transaction table
function addTransdata($limit, $conn, $faker)
{
    for ($i = 0; $i < $limit; $i++) {
        $employeeId = $faker->numberBetween(1, 200);
        $officeId = $faker->numberBetween(1, 50);
        $date = $faker->date;
        $action = $faker->randomElement(['Cash Payment', 'Loan', 'Loan Payment', 'Order Purchase']);
        $remarks = $faker->optional()->word;
        $documentCode = $faker->countryCode;

        $stmt = $conn->prepare("INSERT INTO transaction(employee_id, office_id, datelog, action, remarks, documentcode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $employeeId, $officeId, $date, $action, $remarks, $documentCode);

        executeStatement($stmt);
    }
}

// Execute the statement and handle errors
function executeStatement($stmt)
{
    if ($stmt->execute()) {
        echo "New record created successfully\n";
    } else {
        echo "Error: " . $stmt->error . "\n";
    }
}

// Calling the adding data methods to populate the created tables
addEmpData(200, $conn, $faker);
addOffData(50, $conn, $faker);
addTransdata(500, $conn, $faker);

?>
