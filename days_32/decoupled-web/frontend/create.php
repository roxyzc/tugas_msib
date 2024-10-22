<?php
session_start();
include 'api.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $api = new API($_SESSION['token']);

    $surveyData = json_decode($_POST['survey_data'], true);

    if (is_array($surveyData)) {
        $data = [
            'title' => $surveyData['title'],
            'survey_data' => $surveyData,
        ];


        $response = $api->createSurvey($data);

        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Survei</title>
    <link href="https://unpkg.com/survey-core/defaultV2.min.css" type="text/css" rel="stylesheet">
    <link href="https://unpkg.com/survey-creator-core/survey-creator-core.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/survey-core/survey.core.min.js"></script>
    <script src="https://unpkg.com/survey-js-ui/survey-js-ui.min.js"></script>
    <script src="https://unpkg.com/survey-creator-core/survey-creator-core.min.js"></script>
    <script src="https://unpkg.com/survey-creator-js/survey-creator-js.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Roxyzc</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Daftar Survey</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Buat Survey Baru</h1>
        <form id="surveyForm" method="POST" action="create.php">
            <input type="hidden" name="survey_data" id="survey_data">
            <div id="surveyCreator" style="height: 80vh;"></div>
            <button type="submit" class="btn btn-primary mt-3">Buat Survey</button>
        </form>
    </div>

    <script>
        const creatorOptions = {
            showLogicTab: true,
            isAutoSave: true
        };

        const creator = new SurveyCreator.SurveyCreator(creatorOptions);

        document.addEventListener("DOMContentLoaded", function() {
            creator.render(document.getElementById("surveyCreator"));
        });

        document.getElementById('surveyForm').onsubmit = function() {
            const surveyJson = creator.text;
            document.getElementById('survey_data').value = surveyJson;
        };
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>