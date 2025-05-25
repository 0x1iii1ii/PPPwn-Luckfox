<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPPwn-Luckfox Web Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>PPPwn-Luckfox Web Dashboard for PS4 9.00 & 11.00</h1>
            <h2> ★ v1.2.7 ★ </h2>
        </header>
        <main>
            <div class="button-group">
                <form method="post" action="">
                    <button type="submit" name="run_pppwn" class="button"> Run PPPwn</button>
                    <button type="submit" name="shutdown" class="button"> Shutdown Luckfox</button>
                    <button type="submit" name="eth0" class="button"> Disable Eth0</button>
                </form>
            </div>
            <div class="link-group">
                <a href="config.php" class="button"> Config</a>
                <a href="./900/index.html" class="button"> 9.00 Payloads</a>
                <a href="./1100/index.html" class="button"> 11.00 Payloads</a>
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
            <p>credits: <a href="https://github.com/TheOfficialFloW/PPPwn">@theflow</a>,
                        <a href="https://github.com/xfangfang/PPPwn_cpp">@xfangfang </a>,
                        <a href="https://github.com/SiSTR0">@SiSTR0</a>,
                        <a href="https://github.com/0x1iii1ii/PPPwn-Luckfox">@0x1iii1ii</a>,
                        <a href="https://github.com/harsha-0110/PPPwn-Luckfox">@harsha-0110</a>,
                        <a href="https://github.com/nn9dev/PPPwn_cpp">@nn9dev</a>,
                        <a href="https://github.com/stooged/PI-Pwn">@stooged</a>, and
                        <a href="https://github.com/Scene-Collective">@everyone</a> who contributed to the PS4 scene!</p>
        </footer>
    </div>
  <img src="flag.png" alt="your flag" class="flag">
</body>
</html>