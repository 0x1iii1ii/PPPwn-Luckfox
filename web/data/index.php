<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPPwn-Luckfox Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: black;
        }
        .container {
            max-width: 800px;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 40px;
            color: #333;
        }
        .button {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            color: #fff;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
            cursor: pointer;
        }
        .button:hover {
            background: linear-gradient(135deg, #0056b3, #004099);
            transform: translateY(-2px);
        }
        .button:active {
            transform: translateY(1px);
        }
        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            white-space: pre-wrap;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>PPPwn-Luckfox Web Dashboard for PS4 9.00 & 11.00</h1>
    <h4>by <a href=https://github.com/0x1iii1ii/PPPwn-Luckfox>@0x1iii1ii</a> <a href=https://github.com/harsha-0110/PPPwn-Luckfox>@harsha-0110</a>  </h4>
    <h4>credits to <a href=https://github.com/Scene-Collective>@everyone</a> for the payloads!</h4>
    <form method="post" action="" style="display:inline;">
        <button type="submit" name="run_pppwn" class="button">Run PPPwn</button>
        <button type="submit" name="shutdown" class="button">Shutdown Luckfox</button>
        <button type="submit" name="eth0" class="button">Disable Eth0</button>
    </form>
    <br>
    <a href="config.php" class="button">Config</a>
    <a href="./900/index.html" class="button">9.00 Payloads</a>
    <a href="./1100/index.html" class="button">11.00 Payloads</a>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $config_file = '/etc/pppwn/config.json';
            if (file_exists($config_file)) {
                $config_data = json_decode(file_get_contents($config_file), true);
                if (isset($_POST['shutdown'])) {
                    $config_data['shutdown_flag'] = true; // Set the shutdown flag
                    file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    echo "<div class='output'><h2>Output:</h2><p>The Luckfox will shut down shortly.</p></div>";
                }
                if (isset($_POST['run_pppwn'])) {
                    $config_data['execute_flag'] = true; // Set the execute flag
                    file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    echo "<div class='output'><h2>Output:</h2><p>The PPPwn will execute shortly.</p></div>";
                }
                if (isset($_POST['eth0'])) {
                    $config_data['eth0_flag'] = true; // Set the execute flag
                    file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    echo "<div class='output'><h2>Output:</h2><p>Ethernet0 will be down shortly.</p></div>";
                }
            } else {
                echo "<div class='output'><h2>Error:</h2><p>Configuration file not found.</p></div>";
            }
        }
      ?>
</div>
</body>
</html>
