up:
	docker compose up -d
ssh:
	docker exec -it lumen-pest-plugin ash
test:
	docker exec -it lumen-pest-plugin ./vendor/bin/pest
