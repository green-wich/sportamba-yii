sportamba-yii
=============

Пользователи
--------------

- `api/user/login?provider=Vkontakte [GET]` - авторизация Vkontakte
- `api/user/login?provider=Facebook  [GET]` - авторизация Facebook
- `api/user/logout                   [GET]` - logout
- `api/user/status                   [GET]` - проверяет залогинен пользаватель или нет
- `api/user/current                  [GET]` - информация о текущем пользователе
- `api/user                          [GET]` - все пользователи без учета друзей
- `api/user/:id                      [GET]` - информация о пользователе по id
- `api/user/news                     [GET]` - новости пользователя

Матчи
--------------

- `/api/match     [GET]`  - список всех матчей
- `/api/match/:id [GET]`  - информация по конкретному матчу
- `/api/usermatch [POST]` - добавление матча в профайл юзера
```javascript
    {"usermatch": {
            "match_id": 2,
            "command_id": 2,
            "type_place_viewing": 3, // тип места просмотра, 1 - дома, 2 - на стадионе, 3 - в баре
            "permission_post": 1, // делать пост в соц сеть или нет: 1 - делать, 0 - нет (работает только Facebook)
            "place_viewing": "bar-name" // место просмотра, если например пользователь выбрал
                                        // дома, то сюда соответственно передаем "ТВ, стрим или Стенограмма";
                                        // на стадионе -> название стадиона
                                        // в баре -> название бара
        }
    } 
```
- `/api/usermatch      [GET]` - список всех матчей которые запланировал пользователь
- `/api/usermatch/:id  [GET]` - информация об добавленном в профайл юзера матче
- `/api/usermatch/:id  [PUT]` - обновление информация об добавленном в профайл юзера матче
```javascript   
    {"usermatch": {
            "match_id": 2,
            "command_id": 2,
            "type_place_viewing": 3,
            "place_viewing": "bar-name"
        }
    }
```
- `/api/usermatch/:id  [DELETE]` - удаление матча из профайла

Друзья пользователя
----------------

- `/api/connection           [POST]` - добавление пользоветеля в друзья
```javascript 
    {"connection": {
            "user_id_2": 5
        }
    }
```
- `/api/connection            [GET]` - список моих друзей
- `/api/connection/users      [GET]` - список пользователей которые меня добавили в друзья
- `/api/connection/:id        [DELETE]` - удаление пользователя из друзей (отписаться)
