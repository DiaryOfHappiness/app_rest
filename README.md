Web-сервіс
================================

## Розгортання проекту

### Встановити компоненти через composer

Перейти в корінь проекту:

    php composer.phar install

## Розгортання проекту з використанням Vagrant

### Запустити Vagrant

Перейти в корінь проекту:

    vagrant up

### Підключитися до віртуальної машини Vagrant
Перейти в корінь проекту:

    vagrant ssh
    
Далі перейти:

    cd /var/www/

Встановити компоненти через composer:
    
    php composer.phar install


## Приклади запитів

### Посилання на сутність клієнта:
    http://yii2restfullapi.host/api/v1/client

### Створити клієнта

#### Запит:

    POST /api/v1/client HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
    { "firstName":"Петро", "lastName":"Калиш", "phones": ["+380661144222","05022553653","05024553653"] }
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": {
            "id": "84",
            "firstName": "Петро",
            "lastName": "Калиш",
            "phones": [
                "+380661144222",
                "05022553653",
                "05024553653"
            ]
        }
    }

### Редагувати клієнта

#### Запит:

    PUT /api/v1/client/84 HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
    { "firstName":"Петро", "lastName":"Калишюк", "phones": ["+380661144222","+380661144111"] }
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": {
            "id": "84",
            "firstName": "Петро",
            "lastName": "Калишюк",
            "phones": [
                "+380661144222",
                "+380661144111"
            ]
        }
    }


### Отримати дані клієнта

#### Запит:

    GET /api/v1/client/84 HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": {
            "id": "84",
            "firstName": "Петро",
            "lastName": "Калишюк",
            "phones": [
                {
                    "id": "49",
                    "clientId": "84",
                    "phone": "+380661144222"
                },
                {
                    "id": "52",
                    "clientId": "84",
                    "phone": "+380661144111"
                }
            ]
        }
    }

### Вивести список клієнтів

#### Запит:

    GET /api/v1/client HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": [
            {
                "id": "80",
                "firstName": "Петро",
                "lastName": "Калиш",
                "phones": [
                    {
                        "id": "37",
                        "clientId": "80",
                        "phone": "+380661144222"
                    },
                    {
                        "id": "38",
                        "clientId": "80",
                        "phone": "05022553653"
                    },
                    {
                        "id": "39",
                        "clientId": "80",
                        "phone": "05024553653"
                    }
                ]
            },
            .
            .
            .
        ]
    }

### Видалити клієнта

#### Запит:

    DELETE /api/v1/client/84 HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": {
            "id": "84",
            "firstName": null,
            "lastName": null,
            "phones": []
        }
    }


### Видалити всіх клієнтів

#### Запит:

    DELETE /api/v1/client HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
#### Відповідь:

    {
        "success": true,
        "status": 200,
        "message": "OK",
        "result": {
            "message": "MODEL.CLIENT.MESSAGE.CLEAR_CLIENT"
        }
    }

### Зразок невдалої відповіді

#### Запит:

    PUT /api/v1/client/333 HTTP/1.1
    Host: yii2restfullapi.host
    Cache-Control: no-cache
    
    { "firstName111111111111111":"Петро", "lastName":"ПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтроПЕтро", "phones": ["+380661"] }
    
#### Відповідь:

    {
        "success": false,
        "status": 200,
        "message": "error",
        "errors": {
            "firstName": [
                "MODEL.CLIENT.ERROR.IS_EMPTY"
            ],
            "lastName": [
                "MODEL.CLIENT.ERROR.MAX_LENGTH_60"
            ],
            "phones": [
                "MODEL.CLIENT.ERROR.BAD_FORMAT_PHONE"
            ]
        }
    }


