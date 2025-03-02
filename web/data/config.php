<?php
// Define the file where the configuration will be stored
$config_file = '/etc/pppwn/config.json';
$backup_file = '/etc/pppwn/config_bak.json';

// Function to load configuration from the file
function load_config($file) {
    if (file_exists($file)) {
        $config_data = file_get_contents($file);
        return json_decode($config_data, true);
    }
    return [];
}

// Function to save configuration to the file
function save_config($file, $config) {
    $config_data = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($file, $config_data);
}

// Load current configuration
$config = load_config($config_file);

// Check if the restore button was pressed
if (isset($_GET['restore']) && $_GET['restore'] === 'true') {
    if (file_exists($backup_file)) {
        // Replace config.json with config_bak.json content
        copy($backup_file, $config_file);
        $message = "Configuration restored from backup.";
        // Reload the page to reflect changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $message = "Backup file not found.";
    }
}
    
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the normal form submission for updating configuration
    if (isset($_POST['FW_VERSION']) && isset($_POST['TIMEOUT']) && isset($_POST['WAIT_AFTER_PIN']) && isset($_POST['GROOM_DELAY']) && isset($_POST['BUFFER_SIZE'])) {
        $config['FW_VERSION'] = $_POST['FW_VERSION'];
        $config['PPPWN_EXEC'] = $_POST['PPPWN_EXEC'];
        $config['GOLD_CHECK'] = isset($_POST['GOLD_CHECK']);
        $config['TIMEOUT'] = $_POST['TIMEOUT'];
        $config['WAIT_AFTER_PIN'] = $_POST['WAIT_AFTER_PIN'];
        $config['GROOM_DELAY'] = $_POST['GROOM_DELAY'];
        $config['BUFFER_SIZE'] = $_POST['BUFFER_SIZE'];
        $config['AUTO_RETRY'] = isset($_POST['AUTO_RETRY']);
        $config['NO_WAIT_PADI'] = isset($_POST['NO_WAIT_PADI']);
        $config['REAL_SLEEP'] = isset($_POST['REAL_SLEEP']);
        $config['AUTO_START'] = isset($_POST['AUTO_START']);
        $config['HALT_CHOICE'] = isset($_POST['HALT_CHOICE']);
        save_config($config_file, $config);
        $message = "Configuration updated successfully.";
    } else {
        $message = "Error: Please provide all required values.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPPwn Configuration</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            min-height: 100vh;
        }

        .container {
            min-height: 100vh;
            padding: 40px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }

        input[type="text"],
        input[type="number"],
        select {
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 18px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .checkbox-group label {
            font-weight: normal;
            margin: 0;
        }

        .button-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .button:active {
            transform: translateY(1px);
        }

        .flag {
            position: fixed;
            top: 10px;
            left: 10px;
            width: 50px;
            height: auto;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PPPwn-Luckfox Configuration v1.2.6</h1>

        <!-- Display any messages -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Configuration Update Form -->
        <form method="POST">
            <label for="FW_VERSION">PS4 Firmware and GoldHEN:</label>
            <select id="FW_VERSION" name="FW_VERSION" required>
                <option value="900" <?php if ($config['FW_VERSION'] == '900') echo 'selected'; ?>>9.00 - GoldHEN</option>
                <option value="903" <?php if ($config['FW_VERSION'] == '903') echo 'selected'; ?>>9.03 - GoldHEN</option>
                <option value="960" <?php if ($config['FW_VERSION'] == '960') echo 'selected'; ?>>9.60 - GoldHEN</option>
                <option value="1000" <?php if ($config['FW_VERSION'] == '1000') echo 'selected'; ?>>10.00 - GoldHEN</option>
                <option value="1001" <?php if ($config['FW_VERSION'] == '1001') echo 'selected'; ?>>10.01 - GoldHEN</option>
                <option value="1050" <?php if ($config['FW_VERSION'] == '1050') echo 'selected'; ?>>10.50 - GoldHEN</option>
                <option value="1070" <?php if ($config['FW_VERSION'] == '1070') echo 'selected'; ?>>10.70 - GoldHEN</option>
                <option value="1071" <?php if ($config['FW_VERSION'] == '1071') echo 'selected'; ?>>10.71 - GoldHEN</option>
                <option value="1100" <?php if ($config['FW_VERSION'] == '1100') echo 'selected'; ?>>11.00 - GoldHEN</option>
            </select>

            <label for="PPPWN_EXEC">PPPwn Executable:</label>
            <select id="PPPWN_EXEC" name="PPPWN_EXEC">
                <option value="pppwn1" <?php if ($config['PPPWN_EXEC'] == 'pppwn1') echo 'selected'; ?>>pppwn1 - original build by xfanfang</option>
                <option value="pppwn2" <?php if ($config['PPPWN_EXEC'] == 'pppwn2') echo 'selected'; ?>>pppwn2 - custom build by 0x1iii1ii</option>
                <option value="pppwn3" <?php if ($config['PPPWN_EXEC'] == 'pppwn3') echo 'selected'; ?>>pppwn3 - custom build by nn9dev</option>
            </select>

            <label for="TIMEOUT">Timeout in seconds:</label>
            <input type="number" id="TIMEOUT" name="TIMEOUT" value="<?php echo htmlspecialchars($config['TIMEOUT']); ?>" required>

            <label for="WAIT_AFTER_PIN">Wait After Pin in seconds:</label>
            <input type="number" id="WAIT_AFTER_PIN" name="WAIT_AFTER_PIN" value="<?php echo htmlspecialchars($config['WAIT_AFTER_PIN']); ?>" required>

            <label for="GROOM_DELAY">Groom Delay:</label>
            <input type="number" id="GROOM_DELAY" name="GROOM_DELAY" value="<?php echo htmlspecialchars($config['GROOM_DELAY']); ?>" required>

            <label for="BUFFER_SIZE">Buffer Size in bytes:</label>
            <input type="number" id="BUFFER_SIZE" name="BUFFER_SIZE" value="<?php echo htmlspecialchars($config['BUFFER_SIZE']); ?>" required>

            <div class="checkbox-group">
                <input type="checkbox" id="GOLD_CHECK" name="GOLD_CHECK" <?php if ($config['GOLD_CHECK']) echo 'checked'; ?>>
                <label for="GOLD_CHECK">GoldHEN Detection (only work if Auto-Run PPPwn enable)</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="AUTO_RETRY" name="AUTO_RETRY" <?php if ($config['AUTO_RETRY']) echo 'checked'; ?>>
                <label for="AUTO_RETRY">Auto Retry</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="NO_WAIT_PADI" name="NO_WAIT_PADI" <?php if ($config['NO_WAIT_PADI']) echo 'checked'; ?>>
                <label for="NO_WAIT_PADI">No Wait PADI</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="REAL_SLEEP" name="REAL_SLEEP" <?php if ($config['REAL_SLEEP']) echo 'checked'; ?>>
                <label for="REAL_SLEEP">Real Sleep</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="AUTO_START" name="AUTO_START" <?php if ($config['AUTO_START']) echo 'checked'; ?>>
                <label for="AUTO_START">Auto-Run PPPwn on Start-Up</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="HALT_CHOICE" name="HALT_CHOICE" <?php if ($config['HALT_CHOICE']) echo 'checked'; ?>>
                <label for="HALT_CHOICE">Shutdown After Jailbreak</label>
            </div>

            <div class="button-group">
                <a href="../" class="button">Back</a>
                <input type="submit" value="Update Configuration" class="button">
                <a href="?restore=true" class="button">Restore Default Setting</a>
            </div>
        </form>
    </div>
    <img src="flag.png" alt="your flag" class="flag">
</body>
</html>