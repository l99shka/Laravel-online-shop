# <h1 align="center">Сервис интернет-магазин</h1>
- Этот проект реализован с помощью PHP 8.0, Laravel 9.52.16, PostgreSql, Nginx, php-fpm, API Yookassa, Rabbitmq, Ajax

## ___Описание:___
Интернет-магазин с возможностью оплаты товаров через Yookassa и подтверждением E-mail при регистрации.

## ___Функционал сервиса:___
- регистрация пользователя, вход в личный кабинет и выход из него.
- валидация через на заполнеие полей и данных (существующий E-mail, соответсвие логина(E-mail) и пароля) при регистрации, авторизации и оформлении заказа.
- подтверждение E-mail после регистрации.
- статичный сайт.
- просмотр товаров на главной странице, добавление их в корзину (при успешном добалвении добавлено уведомлеие 'Товар добавлен в корзину')
- дерево категорий с отоборажением товаров принадлежащей соотвествующей категории.
- просмотр корзины с добавленными товарами, добавление или уменьшение количества,  общей стоимости определенного товара(-ов) и его удаление, общей стомости всей корзины.
- оформление заказа и отображение продуктов, их количества, общей стоимости определенного товара(-ов) и общей стоимости заказа.
- онлайн-оплата через Yookassa и после успешной оплатты очищается корзина и отправляется сообщение на почту заказчика.
- ежемесячно отправляется сообщение на почту директора магазина со статистикой количетсва и общей стоиости оплаченных заказаов.

## ___Функционал проекта:___

- реалиозвал категории с помощью библиотеки nestedset.
- реализовал API с помощью библотеки Yookassa.
- реализовал Ajax-запросы для: валидации при регистрации, авторизации, офорлмении заказа; добалвении товара в корзину; пагинации.
- реализовал schedule Laravel для ежемесячной отправки статистики по заказам.
- реализовал очередь сообщений Rabbitmq для подтверждения почты и отправки письма на почту после успешной оплаты.
- реалиозвал зависимые инъекции для корзины, заказа, оплаты и сообщений
- реалиозвана авторизация пустого пользователя, если вдруг неавторизованный пользователь добавляет товар в корзину или захочет ее открыть.
- реализована система ролей guest, user, admin
- для теста добавлены сидеры с продуктами и категориями

## ___Что можно доработать:___

- подтверждение телефрна при регистрации и офорлмении заказа.
- в админке добавить функционал с возможностью дрбавления или редактирования категорий и продуктов, подключенить уведолмение при новом оплаченном заказе, его отображения с данными о товарах и заказчика и редактирование статуса заказа (при необходимости), а так же возожность диаолга с пользователями.
- систему учета товаров
- страницы "контакты" и "о нас"
- добавление товаров в избранное и сравнения
- поиск по товарам и фильтры
- восстановление пароля
- личный кабинет с отоборажением необходимой информации

# ___Чтобы запустить проект, выполните:___
___
Создайте контейнеры:
>docker compose build

Запустите их:
>docker compose up -d

Проверьте созданные docker-контейнеры:
>docker ps

Зайдите в контейнер php-fpm:
>docker compose exec php-fpm bash

Далее необходимо создать таблицы:
>php artisan migrate

Либо создать таблицы с тестовыми данными:
>php artisan migrate --seed

Готово :blush:
