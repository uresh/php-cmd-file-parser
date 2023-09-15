<?php

require_once 'CSVReader.php'; // Include the CSVReader class

class Product
{
    public $make;
    public $model;
    public $condition;
    public $grade;
    public $capacity;
    public $colour;
    public $network;

    public function __construct($data)
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}

class DataProcessor
{
    public function processCSVData($data)
    {
        $products = [];
        $uniqueCombinations = [];

        foreach ($data as $record) {
            $products[] = new Product($record);

            // Generate a unique combination key
            $combinationKey = implode('-', array_values($record));

            // Count unique combinations
            if (isset($uniqueCombinations[$combinationKey])) {
                $uniqueCombinations[$combinationKey]['count']++;
            } else {
                $uniqueCombinations[$combinationKey] = $record;
                $uniqueCombinations[$combinationKey]['count'] = 1;
            }

            // Display product object representation
            print_r(new Product($record));
        }

        return [$products, $uniqueCombinations];
    }
}

try {
    if ($argc < 4 || $argv[1] !== '--file' || $argv[3] !== '--unique-combinations') {
        die("Usage: php parser.php --file <filename.csv> --unique-combinations <output.csv>\n");
    }

    $csvFileName = $argv[2];
    $outputFileName = $argv[4]; // Get the value of --unique-combinations

     // Determine the delimiter based on the file extension
     $fileExtension = pathinfo($csvFileName, PATHINFO_EXTENSION);
     $delimiter = $fileExtension === 'tsv' ? "\t" : ",";
 
     // Create an instance of CSVReader with the specified delimiter
     $csvReader = new CSVReader($csvFileName, $delimiter);
     $data = $csvReader->readCSV();

    // Specify the batch size
    $batchSize = 100;
    $totalRows = count($data);
    $batchCount = ceil($totalRows / $batchSize);

    $dataProcessor = new DataProcessor();

    for ($batchIndex = 0; $batchIndex < $batchCount; $batchIndex++) {
        $startRow = $batchIndex * $batchSize;
        $endRow = min(($batchIndex + 1) * $batchSize, $totalRows);
        $batchData = array_slice($data, $startRow, $endRow - $startRow);

        list($products, $uniqueCombinations) = $dataProcessor->processCSVData($batchData);

        // Append batch results to the output file
        $outputFile = fopen($outputFileName, "a");
        if ($outputFile !== false) {
            if ($batchIndex === 0) {
                $header = array_keys(get_object_vars($products[0]));
                $header[] = 'count'; // Add "count" to the header
                fputcsv($outputFile, $header);
            }

            foreach ($uniqueCombinations as $combination) {
                fputcsv($outputFile, $combination);
            }

            fclose($outputFile);
        } else {
            echo "Error: Unable to open the output file '$outputFileName' for writing.\n";
        }
    }

    echo "Unique combinations written to '$outputFileName'\n";
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}