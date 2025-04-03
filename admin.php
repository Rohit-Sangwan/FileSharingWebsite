<?php
$servername = "localhost";
$username = "u438205861_xxxxxxxxxxxxxx";
$password = "3/>wpW1k?P";
$dbname = "u438205861_xxxxxxxxxxxxxx";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateShortCode($length = 6) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

$successMessage = "";
$errorMessage = "";
$generatedLink = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['file_url'])) {
    $file_url = $_POST['file_url'];
    $short_code = generateShortCode();

    $stmt = $conn->prepare("INSERT INTO shared_links (file_url, short_code) VALUES (?, ?)");
    $stmt->bind_param("ss", $file_url, $short_code);
    if ($stmt->execute()) {
        $generatedLink = "https://darksalmon-ibis-974395.hostingersite.com/index.php?code=" . $short_code;
        $successMessage = "Download link created successfully!";
    } else {
        $errorMessage = "Error creating link: " . $conn->error;
    }
    $stmt->close();
}

// Delete link functionality
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM shared_links WHERE id = $delete_id");
    header("Location: admin.php");
    exit();
}

// Fetch statistics
$total_links = $conn->query("SELECT COUNT(*) as count FROM shared_links")->fetch_assoc()['count'];
$total_clicks = $conn->query("SELECT SUM(clicks) as total FROM shared_links")->fetch_assoc()['total'] ?? 0;
$server_load = sys_getloadavg()[0];

// Sorting & Filtering
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$filter_clicks = isset($_GET['min_clicks']) ? intval($_GET['min_clicks']) : 0;

$query = "SELECT id, file_url, short_code, clicks, ip_address, user_agent FROM shared_links WHERE clicks >= $filter_clicks ORDER BY $sort_by DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage & Share Links</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 900px; padding-top: 50px; }
        .btn-custom { font-size: 14px; }
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .stats-box { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
    </style>
    <script>
        function copyLink(id) {
            var copyText = document.getElementById("link-" + id);
            copyText.select();
            document.execCommand("copy");
            alert("Link copied to clipboard!");
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Admin Dashboard - Manage & Share Links</h2>
        
        <?php if ($successMessage) { echo "<div class='alert alert-success'>$successMessage</div>"; } ?>
        <?php if ($errorMessage) { echo "<div class='alert alert-danger'>$errorMessage</div>"; } ?>

        <!-- Statistics Dashboard -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-box text-center">
                    <h4>Total Links</h4>
                    <p class="fw-bold text-primary"> <?= $total_links ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box text-center">
                    <h4>Total Clicks</h4>
                    <p class="fw-bold text-success"> <?= $total_clicks ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-box text-center">
                    <h4>Server Load</h4>
                    <p class="fw-bold text-warning"> <?= round($server_load, 2) ?> </p>
                </div>
            </div>
        </div>

        <!-- File Sharing Form -->
        <div class="card p-4 mb-4">
            <form method="post">
                <label for="file_url" class="form-label">Enter File URL:</label>
                <input type="url" name="file_url" id="file_url" class="form-control" placeholder="Paste your file link here" required>
                <button type="submit" class="btn btn-primary btn-custom mt-3">Generate Download Link</button>
            </form>
            <?php if ($generatedLink) { ?>
                <div class="mt-3">
                    <label>Your Generated Link:</label>
                    <input type="text" id="generatedLink" class="form-control" value="<?= $generatedLink ?>" readonly>
                    <button class="btn btn-success btn-custom mt-2" onclick="copyLink('generatedLink')">Copy Link</button>
                </div>
            <?php } ?>
        </div>

        <!-- Sort & Filter -->
        <form method="get" class="mb-3">
            <label>Sort by:</label>
            <select name="sort" class="form-select w-auto d-inline-block">
                <option value="id">Date Created</option>
                <option value="clicks">Clicks</option>
                <option value="short_code">Short Code</option>
            </select>
            <label>Min Clicks:</label>
            <input type="number" name="min_clicks" class="form-control w-auto d-inline-block" min="0">
            <button type="submit" class="btn btn-secondary">Apply</button>
        </form>

        <!-- Manage Shared Links -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Link</th>
                    <th>Clicks</th>
                    <th>IP / User Agent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><input type='text' id='link-<?= $row['id'] ?>' class='form-control' value='https://darksalmon-ibis-974395.hostingersite.com/index.php?code=<?= $row['short_code'] ?>' readonly></td>
                        <td><?= $row['clicks'] ?></td>
                        <td><?= $row['ip_address'] ?><br><small><?= $row['user_agent'] ?></small></td>
                        <td>
                            <button class='btn btn-primary btn-custom' onclick='copyLink(<?= $row['id'] ?>)'>Copy</button>
                            <a href='admin.php?delete_id=<?= $row['id'] ?>' class='btn btn-danger btn-custom' onclick="return confirm('Are you sure you want to delete this link?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
