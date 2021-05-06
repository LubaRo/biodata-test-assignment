# BioData test assignment

### Настройка приложения:
1. Запустить `make setup`
1. Прописать в `common/config/main-local.php` настройки базы данных
    ```php
    ...
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2advanced',
            'username' => '<user>',
            'password' => '<pwd>',
            'charset' => 'utf8',
        ],
    ...
    ```
1. Запустить миграцию базы данных `php yii migrate`

---

### Точки входа в приложения
- api: `appDir/api/web/index.php`
- frontend: `appDir/frontend/web/index.php`
- backend:  `appDir/backend/web/index.php`

---

### Доступ в панель администратора
Логин: `admin` <br>
Пароль: `123`

___

### API
- для авторизации необходимо указать токен в заголовке `X-Api-Key`
- значение токена настраивается в `api/config/params-local.php`

Пример запроса:
`curl -i -H "Accept:application/json" -H "X-Api-Key:<your-token>" "http://localhost/api/web/users"`

---

### Facebook credentials
Настройки задаются в `frontend/config/main.php`

```php
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '<your-key>',
                    'clientSecret' => '<your-secret>',
                ],
            ],
        ],
```