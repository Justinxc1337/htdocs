<?php
include './includeviews/header.php';

session_start();


// Funktionel kurv testes, dog med fiktive priser, som er random.
// Den burde været lavet i controller, men der var lidt fejl, så jeg har lavet det i view sammen med HTML'en.
class Database {
    public function getProduct($id) {
        $products = [
            1 => ['navn' => 'Cherry Tomater', 'pris' => rand(10, 20)],
            2 => ['navn' => 'Roma Tomater', 'pris' => rand(15, 25)],
            3 => ['navn' => 'Bøftomater', 'pris' => rand(20, 30)]
        ];

        return isset($products[$id]) ? (object)$products[$id] : null;
    }
}

$db = new Database();

function updateCart($id, $antal) {
    $_SESSION['kurv'][$id] = $antal;
}

// forbundet til session for at fremvise at forskellige bruger har forskellige vare i kurven.
if (!isset($_SESSION['kurv'])) {
    $_SESSION['kurv'] = [
        1 => rand(1, 5),
        2 => rand(1, 5),
        3 => rand(1, 5)
    ];
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/kurv.css">
    <title>Min Kurv</title>
</head>
<body>
    <main>
        <h1>Min Kurv</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Produkter</th>
                        <th>Pris (DKK)</th>
                        <th>Antal</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['kurv'] as $id => $antal): ?>
                        <?php $produkt = $db->getProduct($id); ?>
                        <?php if ($produkt): ?>
                            <?php $subtotal = $produkt->pris * $antal; ?>
                            <?php $total += $subtotal; ?>
                            <tr>
                                <td><?= $produkt->navn ?></td>
                                <td><?= $produkt->pris ?></td>
                                <td><input type="number" name="antal[<?= $id ?>]" value="<?= $antal ?>" min="0"></td>
                                <td><?= $subtotal ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?= $total ?></td>
                    </tr>
                </tfoot>
            </table>
            <button type="submit">Opdater kurv</button>
        </form>
        <a href="index.php?side=bestil">Bestil</a>
    </main>
</body>
</html>
