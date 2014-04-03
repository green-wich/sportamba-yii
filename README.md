sportamba-yii
=============

Пользователи:
1. api/user/login?provider=Vkontakte [GET] - авторизация Vkontakte
2. api/user/login?provider=Facebook  [GET] - авторизация Facebook
3. api/user/logout                   [GET] - logout
3. api/user/status                   [GET] - проверяет залогинен пользаватель или нет

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

