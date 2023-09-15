# CSV/TSV Parser and Processor

This is a PHP-based CSV/TSV file parser and processor that allows you to parse CSV and TSV files, create Product objects, and generate unique combinations with counts.

## Features

- Supports both CSV and TSV file formats.
- Parses the input file row by row into Product objects.
- Generates unique combinations of data fields with counts.
- Outputs the unique combinations to a specified file.

## Getting Started

### Prerequisites

- PHP 7 or higher installed on your system.

### Usage

1. Clone this repository to your local machine:

   ```bash
   git clone https://github.com/uresh/php-cmd-file-parser.git
   ```

2. Navigate to the project directory:

   ```bash
   cd csv-tsv-parser
   ```

3. Run the parser.php script with the following command, replacing `<input-file>` and `<output-file>` with your file paths:

   ```bash
   php parser.php --file <input-file> --unique-combinations <output-file>
   ```

   Example:

   ```bash
   php parser.php --file example.csv --unique-combinations combination_count.csv
   ```

4. The script will process the input file, display Product objects, and create an output file with unique combinations and counts.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
```

This README provides an overview of the project, instructions for getting started, and details on how to run the script. Make sure to replace `<input-file>` and `<output-file>` with actual file paths, and customize it further if needed to suit your project's specific requirements.
