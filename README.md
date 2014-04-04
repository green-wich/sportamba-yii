sportamba-yii
=============

Пользователи:
1. api/user/login?provider=Vkontakte [GET] - авторизация Vkontakte
2. api/user/login?provider=Facebook  [GET] - авторизация Facebook
3. api/user/logout                   [GET] - logout
3. api/user/status                   [GET] - проверяет залогинен пользаватель или нет
4. api/user/current                  [GET] - информация о текущем пользователе
5. api/user                          [GET] - все пользователи без учета друзей

Матчи:
1. /api/match     [GET]  - список всех матчей
2. /api/match/:id [GET]  - информация по конкретному матчу
3. /api/usermatch [POST] - добавление матча в профайл юзера
    {"usermatch": {
            "match_id": 2,
            "command_id": 2,
            "type_place_viewing": 3, // тип места просмотра, 1 - дома, 2 - на стадионе, 3 - в баре
            "place_viewing": "bar-name" // место просмотра, если например пользователь выбрал
                                        // дома, то сюда соответственно передаем "ТВ, стрим или Стенограмма";
                                        // на стадионе -> название стадиона
                                        // в баре -> название бара
        }
    }
4. /api/usermatch      [GET] - список всех матчей которые запланировал пользователь
5. /api/usermatch/:id  [GET] - информация об добавленном в профайл юзера матче
6. /api/usermatch/:id  [PUT] - обновление информация об добавленном в профайл юзера матче
    {"usermatch": {
            "match_id": 2,
            "command_id": 2,
            "type_place_viewing": 3,
            "place_viewing": "bar-name"
        }
    }

Друзья пользователя:
1. /api/connection           [POST] - добавление пользоветеля в друзья
    {"connection": {
            "user_id_2": 5
        }
    }
2. /api/connection            [GET] - список моих друзей
3. /api/connection/users      [GET] - список пользователей которые меня добавили в друзья
