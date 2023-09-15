<?php

class CSVReader
{
    private $csvFileName;
    private $headerMapping;
    private $delimiter; // delimiter property

    public function __construct($csvFileName, $delimiter = ',')
    {
        $this->csvFileName = $csvFileName;
        $this->delimiter = $delimiter; // Store the delimiter
        // Define header mapping
        $this->headerMapping = [
            'brand_name' => 'make',
            'model_name' => 'model',
            'condition_name' => 'condition',
            'grade_name' => 'grade',
            'gb_spec_name' => 'capacity',
            'colour_name' => 'colour',
            'network_name' => 'network',
        ];
    }

    public function readCSV()
    {
        $data = [];
        if (($handle = fopen($this->csvFileName, "r")) !== false) {
            $header = fgetcsv($handle,0, $this->delimiter); // Get the header row with the specified delimiter

            // Map header names to object properties
            $header = array_map(function ($header) {
                return $this->headerMapping[$header] ?? $header;
            }, $header);

            while (($row = fgetcsv($handle, 0, $this->delimiter)) !== false) { // Use the specified delimiter
                $record = array_combine($header, $row);
                $data[] = $record;
            }

            fclose($handle);
        } else {
            throw new Exception("Error: Unable to open the CSV file '{$this->csvFileName}' for reading.");
        }

        return $data;
    }
}