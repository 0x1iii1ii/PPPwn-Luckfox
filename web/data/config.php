<?php
// Define the file where the configuration will be stored
$config_file = '/etc/pppwn/config.json';
$backup_file = '/etc/pppwn/config_bak.json';

// Function to load configuration from the file
function load_config($file)
{
    if (file_exists($file)) {
        $config_data = file_get_contents($file);
        return json_decode($config_data, true);
    }
    return [];
}

// Function to save configuration to the file
function save_config($file, $config)
{
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
    if (isset($_POST['FW_VERSION']) && isset($_POST['TIMEOUT']) &&
        isset($_POST['WAIT_AFTER_PIN']) && isset($_POST['GROOM_DELAY']) && isset($_POST['BUFFER_SIZE']) &&
        isset($_POST['SPRAY_NUM']) && isset($_POST['PIN_NUM']) && isset($_POST['CORRUPT_NUM'])) {
        $config['FW_VERSION'] = $_POST['FW_VERSION'];
        $config['PPPWN_EXEC'] = $_POST['PPPWN_EXEC'];
        $config['TIMEOUT'] = $_POST['TIMEOUT'];
        $config['WAIT_AFTER_PIN'] = $_POST['WAIT_AFTER_PIN'];
        $config['GROOM_DELAY'] = $_POST['GROOM_DELAY'];
        $config['BUFFER_SIZE'] = $_POST['BUFFER_SIZE'];
        $config['PPPWN_IPV6'] = isset($_POST['PPPWN_IPV6']);
        $config['GOLD_CHECK'] = isset($_POST['GOLD_CHECK']);
        $config['AUTO_RETRY'] = isset($_POST['AUTO_RETRY']);
        $config['NO_WAIT_PADI'] = isset($_POST['NO_WAIT_PADI']);
        $config['REAL_SLEEP'] = isset($_POST['REAL_SLEEP']);
        $config['AUTO_START'] = isset($_POST['AUTO_START']);
        $config['HALT_CHOICE'] = isset($_POST['HALT_CHOICE']);
        // nn9dev PPPwn options
        $config['SPRAY_NUM'] = $_POST['SPRAY_NUM'];
        $config['PIN_NUM'] = $_POST['PIN_NUM'];
        $config['CORRUPT_NUM'] = $_POST['CORRUPT_NUM'];

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
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>PPPwn-Luckfox Configuration</h1>

        <!-- Display any messages -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Configuration Update Form -->
        <form method="POST">
            <div class="settings-container">

                <!-- Basic Options -->
                <div class="settings-group">
                    <h4>Basic Options</h4>

                    <label for="FW_VERSION">PS4 Firmware:</label>
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

                    <label><input type="checkbox" id="PPPWN_IPV6" name="PPPWN_IPV6" <?php if ($config['PPPWN_IPV6']) echo 'checked'; ?>> PPPwn IPV6</label>
                    <label><input type="checkbox" id="GOLD_CHECK" name="GOLD_CHECK" <?php if ($config['GOLD_CHECK']) echo 'checked'; ?>> GoldHEN Detection</label>
                    <label><input type="checkbox" id="AUTO_START" name="AUTO_START" <?php if ($config['AUTO_START']) echo 'checked'; ?>> Auto-Run PPPwn</label>
                    <label><input type="checkbox" id="HALT_CHOICE" name="HALT_CHOICE" <?php if ($config['HALT_CHOICE']) echo 'checked'; ?>> Shutdown After Jailbreak</label>
                </div>

                <!-- Advanced Options Toggle -->
                <div class="toggle-container">
                    <input type="checkbox" id="showAdvanced" class="toggle-check">
                    <label for="showAdvanced" class="toggle-label">Show Advanced Options</label>

                    <div class="settings-group advanced-options">
                        <h4>Advanced Options</h4>

                        <label for="TIMEOUT">Timeout in seconds:</label>
                        <input type="number" id="TIMEOUT" name="TIMEOUT" value="<?php echo htmlspecialchars($config['TIMEOUT']); ?>" required>

                        <label for="WAIT_AFTER_PIN">Wait After Pin in seconds:</label>
                        <input type="number" id="WAIT_AFTER_PIN" name="WAIT_AFTER_PIN" value="<?php echo htmlspecialchars($config['WAIT_AFTER_PIN']); ?>" required>

                        <label for="GROOM_DELAY">Groom Delay:</label>
                        <input type="number" id="GROOM_DELAY" name="GROOM_DELAY" value="<?php echo htmlspecialchars($config['GROOM_DELAY']); ?>" required>

                        <label for="BUFFER_SIZE">Buffer Size in bytes:</label>
                        <input type="number" id="BUFFER_SIZE" name="BUFFER_SIZE" value="<?php echo htmlspecialchars($config['BUFFER_SIZE']); ?>" required>

                        <label><input type="checkbox" id="AUTO_RETRY" name="AUTO_RETRY" <?php if ($config['AUTO_RETRY']) echo 'checked'; ?>> Auto Retry</label>
                        <label><input type="checkbox" id="NO_WAIT_PADI" name="NO_WAIT_PADI" <?php if ($config['NO_WAIT_PADI']) echo 'checked'; ?>> No Wait PADI</label>
                        <label><input type="checkbox" id="REAL_SLEEP" name="REAL_SLEEP" <?php if ($config['REAL_SLEEP']) echo 'checked'; ?>> Real Sleep</label>

                        <p>nn9dev PPPwn options (Only works with nn9dev PPPwn):</p>

                        <label for="SPRAY_NUM">Spray Number:</label>
                        <input type="number" id="SPRAY_NUM" name="SPRAY_NUM" value="<?php echo htmlspecialchars($config['SPRAY_NUM']); ?>" required>

                        <label for="PIN_NUM">Pin Number:</label>
                        <input type="number" id="PIN_NUM" name="PIN_NUM" value="<?php echo htmlspecialchars($config['PIN_NUM']); ?>" required>

                        <label for="CORRUPT_NUM">Corrupt Number:</label>
                        <input type="number" id="CORRUPT_NUM" name="CORRUPT_NUM" value="<?php echo htmlspecialchars($config['CORRUPT_NUM']); ?>" required>
                    </div>
                </div>

                <div class="button-group">
                    <a href="../" class="button">Back</a>
                    <input type="submit" value="Update Configuration" class="button">
                    <a href="?restore=true" class="button">Restore Default Setting</a>
                </div>
            </div>
        </form>
    </div>
    <img src="flag.png" alt="your flag" class="flag">
</body>

</html>