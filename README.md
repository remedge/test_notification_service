Project setup
===================
- setup `.env.local` file (copy from `.env`)
- `composer install`
- `bin/console doctrine:database:create`
- `bin/console doctrine:migrations:migrate`
- `bin/console doctrine:fixtures:load`

CRON Setup
===================
- Add to crontab the command `0 0 * * * php /path/to/project/bin/console user:check-subscriptions-expiration`.

Console Commands
===================
- User creation: `bin/console user:create {username} {email}`.
- Checking subscriptions: `bin/console user:check-subscriptions-expiration`.
- Starting one consumer: `php bin/console messenger:consume async -vv`.

Project Description
===================
- The project is implemented using the DDD approach.
- The entry points to the application are located in the `App\User\Presentation\Cli` folder.
- Stubs have been written for the functions `check_email` and `send_email` - `App\User\Infrastructure\DummyEmailSender` and `App\User\Infrastructure\DummyEmailChecker`.
- As there are more than 1 million emails and sending takes from 1 to 10 seconds, an asynchronous queue should be used for deferred sending, in this project `symfony/doctrine-messenger` is used.
- `If possible, OOP should not be used` - I hope this is a joke.

Data Description
===================
- The User entity should always contain a valid email; if it's not valid, the entity should not be created in the database. The function `check_email`
should be invoked when the User entity is created. An example of its use can be seen in the console command `App\User\Presentation\Cli\CreateUserCommand`.
- The `validts` field makes sense to bind to midnight, for example, "May 19 0:00" so that the CRON command can be run only once a day.
- The `valid` field is moved to a separate table called `email_check_results`, which represents cached verified emails, in order not to call the highly expensive `check_email` function.
- Indexes have been added to the fields `confirmed` and `validts`, as it's used for data selection.
- In the message `{username}, your subscription is expiring soon` it makes sense to mention exactly how many days are left until the subscription expires, which is done.

Load Calculation
===================
Let's estimate the approximate number of necessary consumers for our queue.
We have ~1,000,000 users.
Sending 1 email takes from 1 to 10 seconds, we take the maximum - 10 seconds.
Let's say we need to fit into 2 days with sending all the emails.
1,000,000 * 10 = 10,000,000 seconds = ~2777 hours = ~116 days.
116 / 2 = 58 consumers.