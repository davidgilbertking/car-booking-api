# Car Booking API

REST API для корпоративной системы бронирования служебных автомобилей.

## 📦 Возможности

- Получение списка доступных автомобилей на заданный промежуток времени
- Фильтрация по модели и категории комфорта
- Авторизация пользователя и фильтрация по его должности
- Учитываются уже забронированные автомобили

---

## 🚀 Установка и запуск

```bash
git clone https://github.com/davidgilbertking/car-booking-api.git
cd car-booking-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

База данных: MySQL  
Версия PHP: ^8.2  
Laravel: ^12

---

## 🔐 Авторизация

Используется базовая авторизация (HTTP Basic Auth) для тестирования:

```
Логин:    test@example.com  
Пароль:  password
```

---

## 🔍 Пример запроса

```bash
curl -u test@example.com:password \
  "http://127.0.0.1:8000/api/available-cars?start_time=2025-04-26T10:00:00&end_time=2025-04-26T14:00:00"
```

---

## 📁 Структура моделей

- `User` принадлежит `Position`
- `Position` связан с `ComfortCategory` (many-to-many)
- `CarModel` связан с `ComfortCategory`
- `Car` принадлежит `CarModel` и `Driver`
- `Trip` связывает `User` и `Car` + содержит время поездки

---

## 🧪 Тестовые данные

Сидеры автоматически добавляют:

- 1 пользователя
- 2 должности
- 3 категории комфорта
- 3 модели автомобилей
- 4 машины
- 2 водителя
