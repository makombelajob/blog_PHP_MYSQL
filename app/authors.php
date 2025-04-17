<?php
global $pdo;
require_once 'includes/dbconnect.php';

$sql = 'SELECT * FROM authors;';
$stmt = $pdo->query($sql);
$authors = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <main class="container">
        <h2 class="fs-1 text-center text-uppercase my-3">Les noms des auteurs</h2>
        <table class="row w-100">
            <thead class="col-12">
                <tr class="bg-warning row rounded-4 my-1">
                    <th class="col fs-1">ID</th>
                    <th class="col fs-1 me-5">lastname</th>
                    <th class="col fs-1 me-5">firstname</th>
                    <th class="col-6 fs-1">Email</th>
                </tr>
            </thead>
            <tbody class="col-12">
            <?php foreach($authors as $author) : ;?>
                <tr class="row bg-primary rounded my-1">
                    <td class="col fs-1 text-white"><?= $author['id'] ;?></td>
                    <td class="col fs-1 text-white"><?= $author['lastname'] ;?></td>
                    <td class="col fs-1 text-white"><?= $author['firstname'] ;?></td>
                    <td class="col-6 fs-1 text-white"><?= $author['email'] ;?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
