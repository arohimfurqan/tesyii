<!DOCTYPE html>
<html>

<head>
    <title>Data Book</title>
    <style type="text/css">
        .page {
            padding: 2cm;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="page">
        <h1>Data Book</h1>
        <table border="0">
            <tr>
                <th>Nama Buku</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
            </tr>
            <?php
            $no = 1;
            foreach ($dataProvider->getModels() as $book) {
            ?>
                <tr>
                    <td><?= $book->nama_buku ?></td>
                    <td><?= $book->penerbit ?></td>
                    <td><?= $book->tahun_terbit ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>

</html>