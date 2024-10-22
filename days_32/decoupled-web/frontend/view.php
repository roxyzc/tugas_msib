<?php
session_start();
include 'api.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$api = new API($_SESSION['token']);
$survey = $api->getSurveyById($_GET['id']);
$createdAt = $survey['data']['created_at'];

if (!$survey['success']) {
    header('Location: index.php');
    exit;
}

$survey = $survey['data'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Survei</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://source.unsplash.com/1600x900/?nature,landscape');
            background-size: cover;
            background-position: center;
        }

        .survey-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Survei App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container survey-container">
        <h1 class="text-center"><?php echo htmlspecialchars($survey['title']); ?></h1>

        <h2>Pertanyaan</h2>
        <?php
        $createdAt = new DateTime($survey['created_at']);
        $formattedDate = $createdAt->format('d-m-Y H:i');
        ?>
        <p class="text-muted">Tanggal Dibuat: <?php echo htmlspecialchars($formattedDate); ?></p>

        <?php
        $questions = json_decode($survey['survey_data'], true);
        foreach ($questions['pages'] as $page) {
            foreach ($page['elements'] as $element) {
                echo '<div class="mb-4 p-3 border rounded shadow-sm bg-light">';
                echo '<h5 class="font-weight-bold">' . htmlspecialchars($element['title']) . '</h5>';
                echo '<p class="text-muted">Tipe: ' . htmlspecialchars($element['type']) . '</p>';
                if ($element['type'] === 'checkbox' && isset($element['choices'])) {
                    echo '<div class="mt-2">';
                    foreach ($element['choices'] as $choice) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" id="' . htmlspecialchars($choice['value']) . '" disabled>'; // Disabled agar tidak bisa dicentang
                        echo '<label class="form-check-label" for="' . htmlspecialchars($choice['value']) . '">' . htmlspecialchars($choice['text']) . '</label>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        ?>
        <div class="text-center mt-4">
            <a href="update.php?id=<?php echo htmlspecialchars($survey['id']); ?>" class="btn btn-primary">Update</a>
            <a href="delete.php?id=<?php echo htmlspecialchars($survey['id']); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus survei ini?');">Delete</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>