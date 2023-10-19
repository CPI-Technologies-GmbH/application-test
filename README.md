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
I think one of the most important features is adding admin API so the admins can see the time trackings.

Rules:

- Everything is allowed to complete the tasks
- You can use any library you want, but you have to justify why you use it
- Although code is now in Controller, this is not how we want to see it in production. Please refactor it, so that the
  code is in the right place
   We can use the Repository patter for the ProjectsController and the TimeTrackingFollowingController but I'm afraid it doesn't make much different. By the way, we can move the authorizations to a form request.
   But we can move the logics in AuthController to a service layer like AuthService.

- When you are done, please create a pull request in the GitHub repository and invite us to review it. Make sure that
  you have your full name in your GitHub - if not, include it in the code or send it via mail reply to the last HR
  email.
