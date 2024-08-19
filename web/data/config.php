<?php

// Define the file where the configuration will be stored
$config_file = '/etc/pppwn/config.json';

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['FW_VERSION']) && isset($_POST['PPPWN_EXEC']) && isset($_POST['TIMEOUT']) && isset($_POST['WAIT_AFTER_PIN']) && isset($_POST['GROOM_DELAY']) && isset($_POST['BUFFER_SIZE'])) {
        $config['FW_VERSION'] = $_POST['FW_VERSION'];
        $config['PPPWN_EXEC'] = $_POST['PPPWN_EXEC'];
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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: black;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .message {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 8px;
            font-size: 16px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-size: 18px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        select {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 18px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }
        input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
        }
        .checkbox-group label {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
        }
        input[type="submit"] {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            align-self: center;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(135deg, #0056b3, #004099);
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .button-group a,
        .button-group button {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: #007bff;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .button-group a:hover,
        .button-group button:hover {
            background: #0056b3;
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

    <form method="POST">
        <label for="FW_VERSION">PS4 Firmware and Goldhen:</label>
        <select id="FW_VERSION" name="FW_VERSION" required>
            <option value="900" <?php if ($config['FW_VERSION'] == '900') echo 'selected'; ?>>9.00 - Goldhen</option>
            <option value="960" <?php if ($config['FW_VERSION'] == '960') echo 'selected'; ?>>9.60 - Goldhen</option>
            <option value="1000" <?php if ($config['FW_VERSION'] == '1000') echo 'selected'; ?>>10.00 - Goldhen</option>
            <option value="1001" <?php if ($config['FW_VERSION'] == '1001') echo 'selected'; ?>>10.01 - Goldhen</option>
            <option value="1100" <?php if ($config['FW_VERSION'] == '1100') echo 'selected'; ?>>11.00 - Goldhen</option>
        </select>

        <label for="PPPWN_EXEC">PPPwn Executable:</label>
        <select id="PPPWN_EXEC" name="PPPWN_EXEC">
            <option value="pppwn" <?php if ($config['PPPWN_EXEC'] == 'pppwn') echo 'selected'; ?>>pppwn</option>
            <option value="pppwn_ipv6" <?php if ($config['PPPWN_EXEC'] == 'pppwn_ipv6') echo 'selected'; ?>>pppwn ipv6</option>
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
            <label for="HALT_CHOICE">Shutdown After Jailbreak (if you tick it, you won't be able to use web server.)</label>
        </div>

        <div class="button-group">
            <button type="button" onclick="window.location.href = '../'">Back</button>
            <input type="submit" value="Update Configuration">
        </div>
    </form>
</div>

</body>
</html>
