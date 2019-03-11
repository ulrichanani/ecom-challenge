# Fullstack Challenge report
Author: Ulrich Anani (ulrichanan@gmail.com)

## Tools that i use

I use the tools listed below:
 - PHP framework Laravel 
 - VueJS for some part of the admin pannel.
 - A MySQL database
 
 ## Tasks achieved
Due to my actual timetable i was unable to works on all the tasks of the challenge.
Below is the list of functionalities i don't add :
- Checkout with Stripe and Paypal payment gateways
- Writing unit tests

## Database

- As i am using the PHP bcrypt function to encrypt the passwords, i increase the customer password field to 100 charaters
- For communicating with the database, i use the Laravel built-in ORM called Eloquent

## Email

I configured the mailer to use one of my gmail account to send mails to the customer when an order is placed.

## Payement

It's a bit difficult for us in our area to access and use Paypal and Stripe payement system so i did not add any payement gate way.
But i would be possible if i have more time to add one of the local online payment system or even paypal.

## Start the project locally

To start the project locally, you must
- Install composer (PHP packages manager) and npm
- Configure the project by creating a .env file in the projects root folder and fills it with the right informations
- Populate the database (don't forget to change the password field length to 100 characters)
- Run `composer install` at the root
- Run `npm install`
- Run `npm run dev`
- Run `php artisan key:generate`
- Run `php artisan storage:link`
- Install maildev and configure the project to let maildev catch outgoing mails 
- Run `php artisan serve`

You can now visit the address 127.0.0.1:8000 in your browser
