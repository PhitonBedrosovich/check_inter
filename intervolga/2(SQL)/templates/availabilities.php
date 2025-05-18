<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление базой данных</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .table-container {
            overflow-x: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        .table-header {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }
        .table-row:hover {
            background-color: #f1f5f9;
            transition: background-color 0.2s ease;
        }
        .table-cell {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-header-cell {
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }

        .col-id {
            width: 80px;
            text-align: center;
        }
        .col-title {
            width: 300px;
            text-align: left;
        }
        .col-category {
            width: 120px;
            text-align: center;
        }
        .col-amount {
            width: 120px;
            text-align: center;
        }
        .col-stock {
            width: 120px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
<div class="container mx-auto p-6 max-w-7xl">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Управление базой данных</h1>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            Несвязанные данные успешно скрыты!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['restore'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            Данные успешно восстановлены!
        </div>
    <?php endif; ?>

    <div class="mb-8 text-center space-x-4">
        <form action="delete.php" method="POST" class="inline-block">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Скрыть несвязанные данные
            </button>
        </form>
        <form action="restore.php" method="POST" class="inline-block">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Показать все данные
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Категории</h2>
        <div class="table-container">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell table-cell col-id">ID</th>
                        <th class="table-header-cell table-cell col-title">Название</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr class="table-row">
                            <td class="table-cell text-gray-600 col-id"><?php echo htmlspecialchars($category['id']); ?></td>
                            <td class="table-cell text-gray-800 col-title"><?php echo htmlspecialchars($category['title']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Товары</h2>
        <div class="table-container">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell table-cell col-id">ID</th>
                        <th class="table-header-cell table-cell col-title">Название</th>
                        <th class="table-header-cell table-cell col-category">ID категории</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="table-row">
                            <td class="table-cell text-gray-600 col-id"><?php echo htmlspecialchars($product['id']); ?></td>
                            <td class="table-cell text-gray-800 col-title"><?php echo htmlspecialchars($product['title']); ?></td>
                            <td class="table-cell text-gray-600 col-category"><?php echo htmlspecialchars($product['category_id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Склады</h2>
        <div class="table-container">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell table-cell col-id">ID</th>
                        <th class="table-header-cell table-cell col-title">Название</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stocks as $stock): ?>
                        <tr class="table-row">
                            <td class="table-cell text-gray-600 col-id"><?php echo htmlspecialchars($stock['id']); ?></td>
                            <td class="table-cell text-gray-800 col-title"><?php echo htmlspecialchars($stock['title']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Наличие</h2>
        <div class="table-container">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="table-header-cell table-cell col-id">ID</th>
                        <th class="table-header-cell table-cell col-amount">Количество</th>
                        <th class="table-header-cell table-cell col-stock">ID товара</th>
                        <th class="table-header-cell table-cell col-stock">ID склада</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($availabilities as $availability): ?>
                        <tr class="table-row">
                            <td class="table-cell text-gray-600 col-id"><?php echo htmlspecialchars($availability['id']); ?></td>
                            <td class="table-cell text-gray-800 col-amount"><?php echo htmlspecialchars($availability['amount']); ?></td>
                            <td class="table-cell text-gray-600 col-stock"><?php echo htmlspecialchars($availability['product_id']); ?></td>
                            <td class="table-cell text-gray-600 col-stock"><?php echo htmlspecialchars($availability['stock_id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html> 