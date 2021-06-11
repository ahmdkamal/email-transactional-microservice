# Email Transactional

The project simulates the real life example for increasing the delivery rate of the sent email in a scalable service using main Mail Server and optional Fallbacks.

Stack using Laravel + Vuejs + Mysql + Redis.

# Prerequisite
Docker

# How to start

- in root folder, copy `.env.exmaple ` to `.env` & change to what ever you want
- #### For Backend Service
  [Check here](./src/README.md)
- #### For Frontend Service
  [Check here](./vuejs/README.md)

- You can import the postman collection `Take Away.postman_collection.json` in src folder Or you can use the frontend to send Emails

### Why ?

Using redis as queuing server, because redis easy to use / configurable and it is faster than the database one.

Using Supervisor, to run the queues.

Using Bulma in Vuejs as Css framework, because according to Vuejs documentation there is a conflict between Vuejs 3 and bootstrap.

Using Mysql, assuming that in future it will have a relation between the user who sends the mail and the mail itself, and json columns not a separate table ( to, cc, bcc ) for assuming there is no need to filter by them and it is only for showing.

For Arch following Service Repository Pattern, using `SendMail` to encapuslate the send mail logic and using it as signleton object because there is no need to reconfigure it everytime it is called. The setters are used to have more dynamic to switch between Main Server and Fallbacks when it is needed.

## How to run test cases?
- cd to src
- run `docker exec -it takeaway_www bash`
- inside the container run `./vendor/bin/phpunit`