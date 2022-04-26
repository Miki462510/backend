# Come avviare il programma:
1) Installare/Avviare Docker = 
-docker run -d -p 8080:80 --name my-apache-php-app --rm -v /home/informatica/Desktop/mio-sito:/var/www/html zener79/php:7.4-apache
-creare la cartella 'mysqldata'
-docker run --name my-mysql-server --rm -v /home/informatica/Desktop/mio-sito/mysqldata:/var/lib/mysql -v /home/informatica/Desktop/mio-sito/dump:/dump -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest
-docker exec -it my-mysql-server bash
-mysql -u root -p < /dump/create_employee.sql
-exit;
2) Cercare e clickare questa URL "http://localhost:8080/frontEnd/index.html"
   Ps il Backend e Il Frontend si trovano nella stessa cartella (mio-sito), per semplificare le cose. 
