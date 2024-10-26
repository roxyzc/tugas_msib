<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <title>Farmrpg</title>
</head>

<body>

</body>

</html>

<script>
    function autoFarm() {
        let url = 'farmrpg.php';

        $.ajax({
            url: url,
            dataType: 'json',
            type: "GET",
            success: function($data) {
                setTimeout(autoFarm, 61000);
                console.log($data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    function login() {
        let url = 'login.php';

        $.ajax({
            url: url,
            dataType: 'json',
            type: "GET",
            success: function($data) {
                console.log($data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    $(document).ready(function() {
        login()
        autoFarm();
    });
</script>