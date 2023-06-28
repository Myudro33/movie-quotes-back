<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="">
    <div style="background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%);min-height:723px; ">
        <div style="text-align: center; padding-top:100px" >
            
            <p style="font-size: 12px; color:#DDCCAA; line-height: 18px;font-family: sans-serif;">{{__('email.movie_quotes')}}</p>
        </div>
        <div style="text-align:start; margin-top:50px; margin-left: 5%;">
            <p style="font-family: sans-serif; sans-serif; font-size: 16px; color:white">{{__('email.email_update_heading')}}</p> 
            <a href="{{env('FRONTEND_URL')}}/{{$token}}?new={{$new_email}}&email=email-update"
                >
                <button style="cursor: pointer; font-family: sans-serif; margin-top: 10px;  text-align:center; background-color:#E31221; border-radius:8px; border:none; color:white;padding: 15px; height:50px; font-size: 16px; text-decoration:none;" >{{__('email.email_update_button')}}</button> 
            </a> 

            <p style="color:white; font-size:16px; font-family:sans-serif; margin-top:30px;">{{__('email.email_paragraph')}}</p>
            <a style="display:inline; width: 100%; white-space:normal" href="{{env('FRONTEND_URL')}}/{{$token}}?new={{$new_email}}&email=email-update" > <p style="white-space:unset; color: #DDCCAA ; text-decoration: none; text-align:left;  padding-top:20px">{{env('FRONTEND_URL')}}/{{$token}}?new={{$new_email}}&email=email-update</p> </a>
            <p style="color:white; font-size:16px; font-family:sans-serif">{{__('email.email_problem')}}</p>
            <p style="color:white; font-size:16px; font-family:sans-serif">{{__('email.crew')}}</p>
        </div>
     </div>
</body> 
</html>