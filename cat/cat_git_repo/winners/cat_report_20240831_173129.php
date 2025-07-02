<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Winner Report</title>
    <style>
        .container {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .winner {
            position: relative;
            margin-bottom: 20px;
        }
        .position {
            font-size: 1.5em;
            font-weight: bold;
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }
        .gold {
            color: gold;
        }
        .silver {
            color: silver;
        }
        .bronze {
            color: #cd7f32;
        }
        .winner h1 {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="winner">
            <h1>Congratulations, <span id="cat-name-1">Misti</span>!</h1>
            <div class="position gold">1</div>
            <p>You are the trophy winner!</p>
            <center><img id="cat-image-1" src="/img_winners/cat1.jpg" alt="Cat with trophy" width="700" height="500"></center>
        </div>
        <div class="winner">
            <h1>Congratulations, <span id="cat-name-2">Nixie</span>!</h1>
            <div class="position silver">2</div>
            <p>You are the second place winner!</p>
            <center><img id="cat-image-2" src="/img_winners/cat2.png" alt="Cat with trophy" width="700" height="500"></center>
        </div>
        <div class="winner">
            <h1>Congratulations, <span id="cat-name-3">JohnCuack</span>!</h1>
            <div class="position bronze">3</div>
            <p>You are the third place winner!</p>
            <center><img id="cat-image-3" src="/img_winners/cat3.webp" alt="Cat with trophy" width="700" height="500"></center>
        </div>
    </div>
</body>
</html>
