<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPPwn-Luckfox Web Dashboard</title>
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

        header {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 0;
            color: #333;
        }

        .button-group form, .link-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
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

        .button i {
            margin-right: 8px;
        }

        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 8px;
            text-align: left;
        }

        footer {
            margin-top: 20px;
            font-size: 16px;
            color: #666;
            text-align: center;
        }

        footer p {
            margin: 5px 0;
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
        <header>
            <h1>PPPwn-Luckfox Web Dashboard for PS4 9.00 & 11.00</h1>
            <h2> ★ v1.2.6 ★ </h2>
        </header>
        <main>
            <div class="button-group">
                <form method="post" action="">
                    <button type="submit" name="run_pppwn" class="button"><i class="fas fa-play"></i> Run PPPwn</button>
                    <button type="submit" name="shutdown" class="button"><i class="fas fa-power-off"></i> Shutdown Luckfox</button>
                    <button type="submit" name="eth0" class="button"><i class="fas fa-network-wired"></i> Disable Eth0</button>
                </form>
            </div>
            <div class="link-group">
                <a href="config.php" class="button"><i class="fas fa-cog"></i> Config</a>
                <a href="./900/index.html" class="button"><i class="fas fa-file-code"></i> 9.00 Payloads</a>
                <a href="./1100/index.html" class="button"><i class="fas fa-file-code"></i> 11.00 Payloads</a>
            </div>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $config_file = '/etc/pppwn/config.json';
                    if (file_exists($config_file)) {
                        $config_data = json_decode(file_get_contents($config_file), true);
                        if (isset($_POST['shutdown'])) {
                            $config_data['shutdown_flag'] = true;
                            file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            echo "<div class='output'><h2>Output:</h2><p>The Luckfox will shut down shortly.</p></div>";
                        }
                        if (isset($_POST['run_pppwn'])) {
                            $config_data['execute_flag'] = true;
                            file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            echo "<div class='output'><h2>Output:</h2><p>The PPPwn will execute shortly.</p></div>";
                        }
                        if (isset($_POST['eth0'])) {
                            $config_data['eth0_flag'] = true;
                            file_put_contents($config_file, json_encode($config_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            echo "<div class='output'><h2>Output:</h2><p>Ethernet0 will be down shortly.</p></div>";
                        }
                    } else {
                        echo "<div class='output'><h2>Error:</h2><p>Configuration file not found.</p></div>";
                    }
                }
            ?>
        </main>
        <footer>
            <p>by <a href="https://github.com/0x1iii1ii/PPPwn-Luckfox">@0x1iii1ii</a></p>
            <p>credits: <a href="https://github.com/TheOfficialFloW/PPPwn">@theflow</a>,
                        <a href="https://github.com/xfangfang/PPPwn_cpp">@xfangfang </a>,
                        <a href="https://github.com/SiSTR0">@SiSTR0</a>,
                        <a href="https://github.com/harsha-0110/PPPwn-Luckfox">@harsha-0110</a>,
                        <a href="https://github.com/nn9dev/PPPwn_cpp">@nn9dev</a>,
                        <a href="https://github.com/stooged/PI-Pwn">@stooged</a>, and
                        <a href="https://github.com/Scene-Collective">@everyone</a> who contributed to the PS4 scene!</p>
        </footer>
    </div>
  <img src="flag.png" alt="your flag" class="flag">
</body>
</html>