<!DOCTYPE html>

<html
 
lang="en">

<head>

    
<meta
 
charset="UTF-8">

    
<meta
 
name="viewport"
 
content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform!</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            text-align: left;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        Welcome to Our Platform!
    </div>

    <div class="content">
        Dear {{ $user->name }},

        Congratulations on successfully registering for our platform!

        To complete your registration, please click the following link:


        Sincerely,
        The Our Platform Team
    </div>

    <div class="footer">
        © {{ date('Y') }} Our Platform. All rights reserved.
    </div>
</div>
</body>
</html>