<?php
function insertData($conn) {
    $csv_file = 'BETA_netflix_titles.csv';
  
    if (($handle = fopen($csv_file, 'r'))!== FALSE) {
      $categories = array();
      $row_num = 0; // Add a counter variable
  
      while (($data = fgetcsv($handle, 1000, ","))!== FALSE) {
        $row_num++; // Increment the counter
  
        if ($row_num == 1) { // Skip the first row
          continue;
        }
  
        preg_match('/^([^,]+)/', $data[10], $match);
        $category_name = trim($match[1]); // Get category name
  
        if (!in_array($category_name, $categories)) {
          $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
          $stmt->bind_param("s", $category_name);
          $stmt->execute();
          $category_id = $conn->insert_id; // get the auto-generated category ID
          $categories[] = $category_name;
        } else {
          $stmt = $conn->prepare("SELECT id FROM categories WHERE name =?");
          $stmt->bind_param("s", $category_name);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          $category_id = $row['id'];
        }
  
        $title = $data[2];
        $release_year = (int) $data[7]; // Convert to integer
  
        // Check if movie already exists
        $stmt = $conn->prepare("SELECT id FROM movies WHERE title =?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
          $stmt = $conn->prepare("INSERT INTO movies (title, release_year, category_id) VALUES (?,?,?)");
          $stmt->bind_param("sii", $title, $release_year, $category_id);
          $stmt->execute();
        }
      }
      fclose($handle);
    }
  }