# Profile App

## Installation steps

1. clone project using git
2. in terminal run following commands
    ```sh
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    npm run dev
    ```
3. in terminal run following command to start server
    ```sh
    php artisan serve --port 8001 --host 0.0.0.0
    ```
4. now on you can access web application in browser at `http://localhost:8001` url

## Web application flow

-   go to `http://localhost:8001/registration` url to create profile
-   after creating profile you will be redirected to profile edit dashboard page at `http://localhost:8001/profile/edit`
    here you can update your profile
-   on logout you will be redirected to login page at `http://localhost:8001` url
-   if you login with email address and password then will be redirected to profile edit dashboard

## Assignment questions answer

a. What was your approach to this project? Did it change as you developed the app further?
-> first i prepare database diagram then prepare backend API specification and then after i developed frontend and intergrate backend API's
and yes app will be changed as we build it further

b. What were the challenges you faced?
-> validation and store and update all fields efficiently was challenging part

c. How differently will you do if you had a couple of more days to complete the assignment? What if you have one full month?
-> if i have one month time than i will make UI more elegant and will make web flow more smoother and will create admin pannel to manage and see user's profile
