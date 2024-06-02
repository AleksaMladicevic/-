<?php
require_once "database.php";

$query_recipes = "SELECT * FROM recipes";
$result_recipes = mysqli_query($conn, $query_recipes);
if ($result_recipes && mysqli_num_rows($result_recipes) > 0) {
    while ($row = mysqli_fetch_assoc($result_recipes)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['instructions'] . "</td>";
        echo "<td><img src='" . $row['image'] . "' alt='" . $row['title'] . "' style='max-width:100px'></td>";
        echo "<td><button class='delete-btn' onclick='deleteRecipe(" . $row['id'] . ")'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No recipes found.</td></tr>";
}
?>
