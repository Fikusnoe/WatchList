# WatchList
Персональный дневник и одновременно платформа, где ты можешь поделиться своим мнением о любом произведении: фильмы, сериалы, книги, игры.

## Архитектура
Запросы проходят через Nginx, который распределяет трафик между PHP-FPM (Laravel) для SSR-страниц и Python (FastAPI) для WebSocket-соединений. Laravel и FastAPI взаимодействуют с БД MySQL для получения данных. Redis выступает в роли брокера сообщений, используется для обмена событиями в реальном времени.

## Запуск: пошаговая инструкция
### 1) Клонирование репозитория

```bash
git clone https://github.com/Fikusnoe/WatchList.git
cd <ваш-путь>/WatchList
```
P.S: В Windows может понадобиться использовать \ вместо / при указании пути к файлам.

### 2) Подготовка окружения
Скопируйте файл с примерами переменных окружения и настройте их под вашу систему:  
```bash
cp .env.example .env
```
Так же отредактируйте конфиги Nginx.  
Для работы на localhost можно сделать так:  
В .env:  
```bash
APP_URL=https://localhost
```
В watchlist.conf:  
```bash
server_name localhost watchlist.fgsfds.ai-info.ru;
```
В api.watchlist.conf:
```bash
server_name api.localhost;  
```

### 3) Генерация SSL-сертификатов
Для работы HTTPS в локальном окружении сгенерируйте самоподписанные сертификаты.
Сначала создайте директорию для хранения сертификатов:
```bash
mkdir -p nginx/certs
```
Затем сгенерируйте сертификаты:
```bash
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout nginx/certs/watchlist.key -out nginx/certs/watchlist crt \
  -subj "/C=RU/ST=Moscow/L=Moscow/O=Development/CN=watchlist.fgsfds.ai-info.ru"
```
Для api:
```bash
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout nginx/certs/api.key -out nginx/certs/api.crt \
  -subj "/C=RU/ST=Moscow/L=Moscow/O=Development/CN=api.watchlist.fgsfds.ai-info.ru"
```

### 4) Запуск контейнеров
```bash
docker compose up -d –build
```
После запуска потребуется ещё пара минут, чтобы установились все зависимости Laravel.

### 5) Установка зависимостей и миграций
Выполните миграции:
```bash
docker-compose exec laravel php artisan migrate
```
Наполнение БД данными (если надо):
```bash
docker-compose exec laravel php artisan db:seed
```

### 6) Доступ к сайту:
| Что | URL / Адрес |
|---|---|
| Приложение | http://localhost |
| Статус API | https://api.localhost |

## Основные сценарии
На данный момент в приложении можно:  
Зайти на главную страницу, откуда можно перейти на тематические страницы.  
На тематических страницах можно увидеть популярные произведения, отзывы, отзывы в реал тайме на произведения выбранной категории.  
Перейдя на страницу каталогов и выбрав категорию - откроется страница со всеми произведениями данной категории. На этой же странице можно сделать поиск по названию или жанру.  
На карточку произведения в каталоге можно нажать и перейти на её страницу с детальным описанием.  
На странице карточки произведения можно оставить отзыв на это произведение и добавить его в список просмотренного/отслеживаемого.  
Список просмотренного/отслеживаемого реализован не полностью (нельзя посмотреть).  

## Структура БД
Список таблиц:  
users – id, name, email, password, timestamp  
works – id, title, type (index), genre, release_year  
watchlists – id, user_id (FK – users), work_id (FK – works), status, timestamps. Index: user_id, status  
reviews – id, user_id (FK – users), work_id (FK – works), rating, text, created_at (index)  

