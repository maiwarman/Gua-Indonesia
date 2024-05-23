<?php
  // ambil parameter q dari permintaan pencarian
  $query = $_GET['q'];

  // lakukan pencarian pada database atau sumber data lainnya
  $results = search($query);

  // tampilkan hasil pencarian dalam format HTML
  echo "<h2>Search Results</h2>";
  foreach ($results as $result) {
    echo "<a href='" . $result['url'] . "'>" . $result['title'] . "</a><br>";
    echo $result['description'] . "<br><br>";
  }

  // definisikan fungsi search untuk melakukan pencarian
  function search($query) {
    // lakukan koneksi ke database atau sumber data lainnya
    $db = new mysqli('localhost', 'username', 'password', 'database_name');
    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
    }

    // lakukan query untuk mencari hasil pencarian
    $sql = "SELECT * FROM pages WHERE title LIKE '%$query%' OR content LIKE '%$query%'";
    $result = $db->query($sql);

    // simpan hasil pencarian ke dalam array
    $results = array();
    while ($row = $result->fetch_assoc()) {
      $results[] = array(
        'title' => $row['title'],
        'description' => $row['description'],
        'url' => $row['url']
      );
    }

    // tutup koneksi ke database
    $db->close();

    // kembalikan hasil pencarian
    return $results;
  }
?>
