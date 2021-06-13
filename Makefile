BACKEND= docker exec -it takeaway_www

run:
	echo "Installing docker"
	cp .env.example .env
	cd backend/src && cp .env.example .env
	docker-compose up -d && ${BACKEND} composer install
	cd frontend && docker-compose up -d
	${BACKEND} php artisan migrate
	echo "WE ARE DONE Installing"

test:
	${BACKEND} ./vendor/bin/phpunit


supervisor-restart:
	docker restart takeaway_supervisor
