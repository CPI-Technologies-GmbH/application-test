# APPLICATION TEST DESCRIPTION
1. Tests are using separate DB. Please, create it with `example_app_test` name and run `php artisan migrate --env=testing`
or revert back changes in `phpunit.xml` to use existent DB. 
2. To check application work with HTTP requests run `php artisan migrate:fresh --seed`
3. Send e-mail command: I assume that it will be started by cron and will prepare statistic for last week.
Also assume then we have reasonable amount of users and projects to do not use chuck.
4. Tests: to save time I did check only about success
5. To save time: implemented not complex error handling

# WELCOME TO THE CPI APPLICATION TEST

We are glad that you are interested in working with us. To get to know you better, we would like to give you a small
task. Please read the following instructions carefully and complete the tasks while you are recording yourself in loom.
If you have any questions, please do not hesitate to contact us. 

*** Please fork this repository and work on your fork. ***

1. Get into the code -
   Check the code, run it and check the tests with for example `./vendor/bin/sail artisan test`

2. Complete the ProjectController with CRUD routes
3. Write tests for the ProjectController
4. Introduce a new model: Time Tracking - Following attributes the new model must have at least:

- id
- project_id
- start_time
- end_time

5. Users should be able to start and stop the timer of the tracking tool, like usual developers do to track their time. 
   Introduce a new Controller to allow users to do so. Important: Users shall not be allowed to edit the time after tracking it.
6. Every Monday we want to send an email to all users that summarizes their time tracking
7. Think about one more feature you would like to add to the application and implement it

Rules:

- Everything is allowed to complete the tasks
- You can use any library you want, but you have to justify why you use it
- Although code is now in Controller, this is not how we want to see it in production. Please refactor it, so that the
  code is in the right place
- When you are done, please create a pull request in the GitHub repository and invite us to review it. Make sure that
  you have your full name in your GitHub - if not, include it in the code or send it via mail reply to the last HR
  email.
