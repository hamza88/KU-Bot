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
        <a href="#" class="pure-menu-heading pure-menu-link">KU Bot</a>
    </header>
    <div id="wrapper">
        <div class="pure-g container">
            <div style="overflow-y: scroll; height: 90%;" class="pure-u-1">
                    <ol class="trending chat-history__messages">
                    <li class="message-box message-box--recieved">
                    <p class="message">
                        <b>Here are the trending topics right now!</b><br/>
                    <?php foreach($trending as $topic): ?>
                    <?php echo $topic->topic . "<br />"; ?>
                <?php endforeach; ?></p>
            </li>
            </ol>
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
