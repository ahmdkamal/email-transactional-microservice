BACKEND= docker exec -it takeaway_www

run:
	echo "Installing docker"
	cp .env.example .env
	cd backend/src && cp .env.exmaple .env
	docker-compose up -d && ${BACKEND} composer install
	cd frontend && cp .env.exmaple .env && docker-compose up -d
	echo "WE ARE DONE Installing"

test:
	${BACKEND} ./vendor/bin/phpunit