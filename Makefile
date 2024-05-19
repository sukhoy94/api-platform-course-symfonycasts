run:
	symfony serve -d && docker stop $$(docker ps -aq) && docker compose up -d
stop:
	symfony server:stop && docker compose down
migrations:
	symfony console make:migration && symfony console doctrine:migrations:migrate
reset_db:
	symfony console doctrine:database:drop --force
create_db:
	symfony console doctrine:database:create
fixtures:
	symfony console doctrine:fixtures:load

