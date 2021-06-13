# Email Transactional

The project simulates the real life example for increasing the delivery rate of the sent email in a scalable service using main Mail Server and optional Fallbacks.

Stack using Laravel8 + Vuejs3 + Mysql5.7 + Redis. ( latest versions )

# Before starting

If you are not Mac M1 user, remove from `docker-compose.yml` this line `platform: linux/x86_6`.

#### Prerequisite
Docker

# How to start

- run `make run`

- You can import the postman collection `Take Away.postman_collection.json` in backend/src folder Or you can use the frontend to send Emails

- You can access the app by following this links
  - for backend `http://localhost:7336`
  - for frontend `http://localhost:7335`

### Available Commands
- `make run` to run the containers and install its dependencies.
- `make test` to run PhpUnit test cases
- `make supervisor-restart` to restart supervisor after changing any of these keys `SENDGRID_API_KEY`, `MailJET_KEY`, `MailJET_SECRET` in backend/src/.env

### Why ?

Using redis as queuing server, because redis easy to use / configurable and it is faster than the database one.

Using Supervisor, to run the queues.

Using Bulma in Vuejs as Css framework, because according to Vuejs documentation there is a conflict between Vuejs 3 and bootstrap.

Using Mysql, assuming that in future it will have a relation between the user who sends the mail and the mail itself, and json columns not a separate table ( to, cc, bcc ) for assuming there is no need to filter by them and it is only for showing.

For Arch following Service Repository Pattern, using `SendMail` to encapuslate the send mail logic and using it as signleton object because there is no need to reconfigure it everytime it is called. The setters are used to have more dynamic to switch between Main Server and Fallbacks when it is needed.
