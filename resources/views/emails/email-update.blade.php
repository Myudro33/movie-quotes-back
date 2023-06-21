<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p align="center" style="margin: 0; font-family: 'Inter', sans-serif;">
        <a href="{{env('FRONTEND_URL')}}/{{$token}}?new={{$new_email}}&email=email-update"
            style="display: inline-block; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #0FBA68; padding: 10px 30px; border-radius: 5px; text-decoration: none;">Update Email</a>
    </p>
</body>
</html>