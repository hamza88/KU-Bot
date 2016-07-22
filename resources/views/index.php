<!doctype html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 value="{ csrf_token() }" >
    <title>Dude Chatbot - Kathmandu University</title>
    <link rel="stylesheet" href="<?php echo elixir('css/app.css'); ?>">
    <link rel="stylesheet" href="css/style.css" >
</head>
<body>
    <header class="header pure-menu pure-menu-horizontal">
        <a href="#" class="pure-menu-heading pure-menu-link">Dude</a>
    </header>
    <div id="wrapper">
        <div class="pure-g container">
            <div class="pure-u-1 chat-history">
                <div class="trending">
                    <h3>Here are the trending topics right now!</h3>
                    <?php foreach($trending as $topic): ?>
                    <li><?php echo $topic->topic; ?></li>
                <?php endforeach; ?>
                </div>
                <chat-history>

                </chat-history>
            </div>

            <div class="pure-u-1 chat-container">
                <chat-box></chat-box>
            </div>
        </div>
    </div>
    <script src="<?php echo elixir('js/app.js'); ?>"></script>
</body>
</html>
