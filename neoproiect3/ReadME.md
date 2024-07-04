README

Movie Database API

This PHP script connects to a MySQL database and provides a RESTful API to retrieve movie data. The script also includes functionality to import movie data from a CSV file into the database.

Requirements

PHP 7.0 or higher
MySQL 5.6 or higher
A CSV file named netflix_titles.csv in the same directory as the script (optional)
Database Configuration

The script connects to a MySQL database using the following credentials:

Server: localhost
Username: root
Password: parola
Database: movies
API Endpoints

The script provides a single API endpoint to retrieve movie data:

GET /: Retrieves a list of movies with pagination. Supports the following query parameters:
offset: The offset of the first movie to retrieve (default: 0)
limit: The number of movies to retrieve (default: 10)
The API returns a JSON response with the following structure:

json

Verify

Open In Editor
Edit
Copy code
[
  {
    "id": 1,
    "title": "Movie Title",
    "category": "Category Name"
  },
  {
    "id": 2,
    "title": "Another Movie",
    "category": "Different Category"
  },
  ...
]
CSV Import

The script can also import movie data from a CSV file named netflix_titles.csv in the same directory. The CSV file should have the following structure:

Column	Description
2	Movie title
7	Release year
10	Category name
The script will create categories and movies in the database based on the data in the CSV file.

Notes

The script uses prepared statements to prevent SQL injection attacks.
The script assumes that the CSV file has the correct structure and data types.
The script does not handle errors or exceptions well. You may want to add additional error handling and logging.
License

This script is provided under the MIT License. See the LICENSE file for details.
