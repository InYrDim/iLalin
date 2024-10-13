<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Perjalanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 50px;
            border-radius: 15px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #6bba71;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Riwayat Perjalanan</h1>
        
        <?php
        // Contoh data riwayat perjalanan
        $travel_history = [
            [
                'destination' => 'Makassar, Bulukumba',
                'travel_date' => '2023-05-10',
                'description' => 'Budiyanto, DD7894KP, 0827284624846',
                'payment_method' => 'Kartu Kredit',
                'payment_amount' => 'Rp 100.000'
            ],
            [
                'destination' => 'Bulukumba, Maros',
                'travel_date' => '2022-12-15',
                'description' => 'Sirregar, DP3768PM, 08935254715',
                'payment_method' => 'Transfer Bank',
                'payment_amount' => 'Rp 150.000'
            ],
            [
                'destination' => 'Maros, Bulukumba',
                'travel_date' => '2021-09-21',
                'description' => 'Afdalh, DP128PK',
                'payment_method' => 'E-Wallet',
                'payment_amount' => 'Rp 150.000'
            ]
        ];
        ?>

        <?php if (!empty($travel_history)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Destinasi</th>
                        <th>Tanggal Perjalanan</th>
                        <th>Deskripsi</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($travel_history as $trip): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trip['destination']); ?></td>
                            <td><?php echo htmlspecialchars($trip['travel_date']); ?></td>
                            <td><?php echo htmlspecialchars($trip['description']); ?></td>
                            <td><?php echo htmlspecialchars($trip['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($trip['payment_amount']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada riwayat perjalanan yang tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>