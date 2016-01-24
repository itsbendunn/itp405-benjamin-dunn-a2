<!DOCTYPE html>
<html>
<head>
    <title>DVD Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>

<?php

if(!isset($_GET['movie'])){
    header('Location: index.php');
    exit();
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pw = 'ttrojan';

$pdo = new PDO("mysql:host=$host; dbname=$dbname", $user, $pw);

$movie = $_GET['movie'];

$sql = "
    SELECT title, genre_name, format_name, rating_name
    FROM dvds
    INNER JOIN genres
    ON dvds.genre_id = genres.id
    INNER JOIN formats
    ON dvds.format_id = formats.id
    INNER JOIN ratings
    ON dvds.rating_id = ratings.id
    WHERE title LIKE ?
";

$statement = $pdo ->prepare($sql);
$like = '%' . $movie . '%';
$statement->bindParam(1, $like); //what does this do again?
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ)


?>
<div class="container">
    <h2>Movie Results</h2>
    <?php foreach ($movies as $movie) : ?>
        <h3>
            <?php echo $movie->title?>
        </h3>
        <p>
            Genre: <?php echo $movie->genre_name ?>
        </p>
        <p>
            Format: <?php echo $movie->format_name?>
        </p>
        <p>
            Rating:<a href="ratings.php?rating=<?php echo $movie->rating_name?>"> <?php echo $movie->rating_name?></a>
        </p>
        <hr>

    <?php endforeach;?>
</div>

</body>
</html>

