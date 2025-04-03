<?php
$servername = "localhost";
$username = "u438205861_xxxxxxxxxxxxxx";
$password = "3/>wpW1k?P";
$dbname = "u438205861_xxxxxxxxxxxxxx";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file_url = ""; // Ensure variable is always set
$clicks = 0;

if (isset($_GET['code'])) {
    $short_code = $_GET['code'];

    $stmt = $conn->prepare("SELECT file_url, clicks FROM shared_links WHERE short_code = ?");
    $stmt->bind_param("s", $short_code);
    $stmt->execute();
    $stmt->bind_result($file_url, $clicks);
    $stmt->fetch();
    $stmt->close();

    if ($file_url) {
        $update_stmt = $conn->prepare("UPDATE shared_links SET clicks = clicks + 1 WHERE short_code = ?");
        $update_stmt->bind_param("s", $short_code);
        $update_stmt->execute();
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; padding-top: 50px; }
        .btn-custom { width: 100%; font-size: 18px; margin-bottom: 10px; }
        .progress { height: 25px; }
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .ad-container { display: block; margin: 10px 0; text-align: center; }
    </style>
    <script>
        function startCountdown(duration) {
            let timer = duration;
            const interval = setInterval(function () {
                document.getElementById('countdown').textContent = timer + "s";
                document.getElementById('progress').style.width = ((30 - timer) / 30) * 100 + '%';
                if (--timer < 0) {
                    clearInterval(interval);
                    document.getElementById('download-btn').style.display = 'block';
                }
            }, 1000);
        }

        function unlockStep(step) {
            if (step === 1) {
                document.getElementById('step2').style.display = 'block';
            } else if (step === 2) {
                document.getElementById('step3').style.display = 'block';
            } else if (step === 3) {
                document.getElementById('steps').style.display = 'none';
                document.getElementById('countdown-container').style.display = 'block';
                startCountdown(30);
            }
        }
    </script>
</head>
<body>
    <div class="container text-center">
        <!-- Adsterra Banner 728x90 -->
        <div class="ad-container">
            <script type="text/javascript">
	atOptions = {
		'key' : '0f711c7d94f1b0cbfbf5da3102d14ea2',
		'format' : 'iframe',
		'height' : 90,
		'width' : 728,
		'params' : {}
	};
</script>
<script type="text/javascript" src="//spotsconcealedunlikely.com/0f711c7d94f1b0cbfbf5da3102d14ea2/invoke.js"></script>
        </div>

        <div class="card p-4">
            <h3 class="mb-3">Complete the Steps to Unlock Your Download</h3>
            
            <?php if (!empty($file_url)) { ?>
                <div id='steps'>
                    <a href='https://www.youtube.com/@RohitSangwanOfficial' target='_blank' class='btn btn-danger btn-custom' onclick='unlockStep(1)'>🔔 Subscribe to My YouTube Channel</a>
                    <button id='step2' class='btn btn-warning btn-custom' style='display:none' onclick='unlockStep(2)'>Unlock Second Step</button>
                    <button id='step3' class='btn btn-success btn-custom' style='display:none' onclick='unlockStep(3)'>Start Timer</button>
                </div>
                <div id='countdown-container' style='display:none'>
                    <h4>Waiting Time: <span id='countdown'></span></h4>
                    <div class='progress mt-3'><div id='progress' class='progress-bar bg-success' role='progressbar' style='width: 0%'></div></div>
                </div>
                <a href='<?= $file_url ?>' class='btn btn-primary btn-custom mt-3' id='download-btn' style='display:none'>📥 Download Now</a>
                <p class='mt-3 text-muted'>Total Clicks: <strong><?= $clicks ?></strong></p>
            <?php } else { ?>
                <div class='alert alert-danger'>Invalid Link!</div>
            <?php } ?>
        </div>

        <!-- Adsterra Banner 300x250 -->
        <div class="ad-container">
            <script type="text/javascript">
	atOptions = {
		'key' : '13f139b58ba167faad89c69ce7d84fef',
		'format' : 'iframe',
		'height' : 250,
		'width' : 300,
		'params' : {}
	};
</script>
<script type="text/javascript" src="//spotsconcealedunlikely.com/13f139b58ba167faad89c69ce7d84fef/invoke.js"></script>
        </div>

        <!-- Adsterra Social Bar -->
        <div class="ad-container">
            <script type='text/javascript' src='//spotsconcealedunlikely.com/e7/6a/6c/e76a6ccb29838efb821e6134248dd7dc.js'></script>
        </div>
    </div>
</body>
</html>
