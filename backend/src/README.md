# How to run  
 - copy `.env.exmaple ` to `.env`  & change `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `SENDGRID_API_KEY`, `MailJET_KEY`  & `MailJET_SECRET` to yours you put in root folder
 - cd to root folder
 - run `docker-compose up -d` ( NOTE if you are not MAC M1, open `docker-compose.yml` and comment `platform: linux/x86_64` line)
 - run `docker exec -it takeaway_www bash` and inside run `composer install` and then `php artisan migrate`
