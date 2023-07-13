<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Movie Quotes</h1>
</div>

---
With Movie Quotes, you can create an account and sign in to unlock a multitude of features. Share your favorite movies and their memorable quotes. The app keeps you connected and informed by providing instant notifications whenever someone likes or comments on your posts.

### Table of Contents
* [Prerequisites](#prerequisites)
* [Tech Stack](#tech-stack)
* [Getting Started](#getting-started)
* [Migrations](#migration)
* [Development](#development)
* [Resources](#resources)

#
### Prerequisites

* <img src="https://cdn-icons-png.flaticon.com/512/919/919830.png" width="35" style="position: relative; top: 4px" /> *PHP x.8.2 and up*
* <img src="https://www.freepnglogos.com/uploads/logo-mysql-png/logo-mysql-mysql-logo-png-images-are-download-crazypng-21.png" width="35" style="position: relative; top: 4px" /> *MYSQL x.8 and up*
* <img src="https://static-00.iconduck.com/assets.00/npm-icon-512x512-qtfdrf37.png" width="35" style="position: relative; top: 4px" /> *NPM x.7 and up*
* <img src="https://camo.githubusercontent.com/9f549df9473b6abc13a0a81d0a91ae56a8d85d641ab271c25b21af450d058e44/68747470733a2f2f676574636f6d706f7365722e6f72672f696d672f6c6f676f2d636f6d706f7365722d7472616e73706172656e742e706e67" width="35" style="position: relative; top: 6px" /> *Composer x.2.5 and up*


#
### Tech Stack

* <img src="https://static-00.iconduck.com/assets.00/laravel-icon-497x512-uwybstke.png" height="18" style="position: relative; top: 4px" /> [Laravel@10.x](https://laravel.com/docs/10.x) - Back-end Framework
* <img src="https://vasterra.com/blog/wp-content/uploads/2021/08/Tailwind-img.png" height="19" style="position: relative; top: 4px" /> [Tailwind CSS](https://tailwindcss.com) - CSS library
* <img  height="19" style="position: relative; top: 4px" src="https://avatars.githubusercontent.com/u/739550?s=280&v=4" /> [Pusher](https://pusher.com) - Notifications

#
## Getting Started
1. First of all you need to clone Movie Quotes repository from github:

```sh
git clone https://github.com/RedberryInternship/nika-qanashvili-movie-quotes-back.git
```

2. Next step requires you to run composer install in order to install all the dependencies:

```sh
composer install
```

3. After you have installed all the PHP dependencies, it's time to install all the JS dependencies:

```sh
npm install
```

4. We need to link our storage folder to public folder:
```sh
php artisan storage:link
```

5. Now we need to set our env file. Go to the root of your project and execute this command.
```sh
cp .env.example .env
```
6. Next we need to generate Laravel key:
```sh
php artisan key:generate
```
7. Now you should provide .env file all the necessary environment variables:

#
**MYSQL:**
>DB_CONNECTION=mysql

>DB_HOST=127.0.0.1

>DB_PORT=3306

>DB_DATABASE=*****

>DB_USERNAME=*****

>DB_PASSWORD=*****


#
**Pusher:**
>ROADCAST_DRIVER=pusher

>PUSHER_APP_ID=*****

>PUSHER_APP_KEY=****

>PUSHER_APP_SECRET=*****

>PUSHER_APP_CLUSTER=*****


#
**App urls:**
>FRONTEND_URL=*****

#
**Sanctum:**
>SESSION_DRIVER=cookie

>SANCTUM_STATEFUL_DOMAINS=****

>SESSION_DOMAIN=****


#
**Google Auth:**

>GOOGLE_CLIENT_ID=****

>GOOGLE_CLIENT_SECRET=****



#
**Email:**
>MAIL_MAILER=*****

>MAIL_HOST=*****

>MAIL_PORT=2525

>MAIL_USERNAME=*****

>MAIL_PASSWORD=*****

>MAIL_ENCRYPTION=*****

>MAIL_FROM_ADDRESS=*****

>MAIL_FROM_NAME="${APP_NAME}"


#
### Database
now we should migrate tables:
```sh
php artisan migrate
```

now we should seed our database:
```sh
php artisan db:seed
```

#
### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

for tailwind css we should run:

```sh
  npm run dev
```

#
### Resources

DrawSQL:
```sh
https://drawsql.app/teams/nika-1/diagrams/movie-quotes
```
<a href="https://drawsql.app/teams/nika-1/diagrams/movie-quotes"><img height='300px' width="50%" src="https://i.ibb.co/1zppwGP/Screenshot-from-2023-07-13-18-19-39.png" alt="Screenshot-from-2023-07-13-18-19-39" border="0"></a>
