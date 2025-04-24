<?php
global $pdo;
require_once 'includes/dbconnect.php';

$sql = 'SELECT * FROM authors;';
$stmt = $pdo->query($sql);
$authors = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<body>
    <main class="container">
        <h2 class="fs-1 text-center text-uppercase my-3">Les noms des auteurs</h2>
        <?php require_once 'includes/options_list.php';?>
        <table class="row w-100">
            <thead class="col-12">
                <tr class="bg-warning row rounded-4 my-1">
                    <th class="col fs-1">ID</th>
                    <th class="col fs-1 me-5">lastname</th>
                    <th class="col fs-1 me-5">firstname</th>
                    <th class="col fs-1">Email</th>

                </tr>
            </thead>
            <tbody class="col-12">
            <?php foreach($authors as $author) : ;?>
                <tr class="row bg-primary rounded-3 my-1">
                    <td class="col fs-1 text-white"><?= $author['id'] ;?></td>
                    <td class="col fs-1 text-white"><?= $author['lastname'] ;?></td>
                    <td class="col fs-1 text-white"><?= $author['firstname'] ;?></td>
                    <td class="col fs-1 text-white"><?= $author['email'] ;?></td>
                    <td class="col-5 fs-1 text-white text-center m-auto"><a class="btn btn-secondary fs-3 w-100 my-1" href="post_specific_author.php/?id=<?= $author['id'];?>">See posts</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
