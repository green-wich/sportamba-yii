(function ($) {
    $.fn.toggleDisabled = function () {
        return this.each(function () {
            this.disabled = !this.disabled;
        });
    };
})(jQuery);
(function ($) {
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);
///////////////////////// ----------------
/////////////////// ----------------
////////////----------------
///// ----------------
var Match = Backbone.Model.extend({
    defaults: {
        id: "",
        command_1: {
            id: "",
            name: "",
            image: ""
        },
        command_2: {
            id: "",
            name: "",
            image: ""
        },
        date: "",
        stadion: {
            name: "",
            lat: "",
            long: ""
        }
    }
});
var UserMatch = Backbone.Model.extend({
    defaults: {
        id: "",
        match: {
            id: "",
            command_1: {
                id: "",
                name: "",
                img: ""
            },
            command_2: {
                id: "1",
                name: "",
                img: ""
            },
            date: ""
        }
    }
});
var User = Backbone.Model.extend({
    defaults: {
        "id": "",
        "name": "",
        "photoUrl": ""
    }

});
var Users = Backbone.Collection.extend({
    url: "/api/user",
    model: User,
    parse: function (resp) {
        return resp.users;
    }
});
var users = new Users();

var MyUsers = Backbone.Collection.extend({
    url: "/api/connection",
    model: User,
    parse: function (resp) {
        return resp.connections;
    }
});
var myUsers = new MyUsers();
var MyPod = Backbone.Collection.extend({
    url: "/api/connection/users",
    model: User,
    parse: function (resp) {
        return resp.connections;
    }
});
var myPod = new MyPod();




var AllUsersView = Backbone.Marionette.ItemView.extend({
    template: '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var AllFriendsView = Backbone.Marionette.ItemView.extend({
    template: '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var MyPodView = Backbone.Marionette.ItemView.extend({
    template: '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});

var FirendsCompos = Backbone.Marionette.CompositeView.extend({
    template: '#usersView',
    events: {
        'click a.tab-item': 'btnCl',
        'touchstart a.tab-item': 'btnCl',
        'click .icon.icon-plus.rig': 'addU',
        'touchstart .icon.icon-plus.rig': 'addU'
    },
    btnCl: function (e) {
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    },
    itemViewContainer: 'ul#allFriends',
    addU: function (e) {
        console.log($(e.currentTarget));
    }
})


var MatchView = Backbone.Marionette.ItemView.extend({
    template: '#match',
    events: {
        'click button': 'fu',
        'touchstart button': 'fu'
    },
    fu: function (e) {
        e.preventDefault();
        //console.log(e);

        $.ajax({
            type: 'POST',
            url: window.location.origin + '/api/usermatch',
            dataType: "json",
            data: JSON.stringify({
                usermatch: $('#matchForm').serializeObject()
            }),
            success: function (data) {
                Backbone.history.navigate("disc", true);
            },
            error: function (data) {
                new IndexPage().render();
            }
        });
        userMatches.fetch();

    }
})
var Matches = Backbone.Collection.extend({
    url: "/api/match",
    model: Match,
    parse: function (resp) {
        return resp.matches;
    }
});

var UserMatches = Backbone.Collection.extend({
    url: '/api/usermatch',
    model: UserMatch,
    parse: function (resp) {
        return resp.usermatches;
    }
});

var Friends = Backbone.Model.extend({
    defaults: {
        id_command1: 'id_command1'
    }
});


var matches = new Matches();
var userMatches = new UserMatches();
var app = new Backbone.Marionette.Application();
app.addInitializer(function () {
    matches.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    });
    userMatches.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    });
    users.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    });
    myUsers.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    });


    myPod.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    });
});

var IndexPage = Backbone.Marionette.ItemView.extend({
    template: "#firstScreen",
    el: '#container',
    events: {
        'click a': 'firstScreenNav',
        'touchstart a': 'firstScreenNav'
    },
    firstScreenNav: function (e) {
        e.preventDefault();
        window.location = window.location.href + $(e.currentTarget).attr('href');
    }
});


var region = new Backbone.Marionette.Region({
    el: '#container'
});


var FriendsNews = Backbone.Model.extend({})
var DisclaimerPage = Backbone.Marionette.ItemView.extend({
    template: "#discPage",
    el: '#container',
    events: {
        'click a': 'btnClick',
        'click .btn': 'btnClick',
        'touchstart a': 'btnClick'
    },
    btnClick: function (e) {
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    }
});


OneItemView = Backbone.Marionette.ItemView.extend({
    template: "#row-template"
});

TableView = Backbone.Marionette.CompositeView.extend({
    itemView: OneItemView,
    itemViewContainer: "ul#news",
    template: "#matchesScreen",
});


var SampleView = Backbone.Marionette.ItemView.extend({
    template: '#sample-template',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var Sample2View = Backbone.Marionette.ItemView.extend({
    template: '#sample2-template',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});

var ahah = Backbone.Marionette.CompositeView.extend({
    template: '#matchesScreen',

    itemViewContainer: 'ul#news',
    events: {
        'click .icon.icon-plus.rig': 'addM',
        'touchstart .icon.icon-plus.rig': 'addM',
        'click a.tab-item': 'btnCli',
        'touchstart a.tab-item': 'btnCli'
    },
    btnCli: function (e) {
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    },
    addM: function (e) {
        console.log($(e.currentTarget));
        Backbone.history.navigate("matches/" + $(e.currentTarget).attr('data-num'), true)
    }
})


var MatchesShow = Backbone.Marionette.ItemView.extend({
    template: "#matchesScreen",
    el: '#container',
    events: {
        'click a.tab-item': 'matchesPage',
        'touchstart a.tab-item': 'matchesPage',
        'touchstart .icon.icon-plus.rig': 'addMatch'
    },
    matchesPage: function (e) {
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    },
    addMatch: function (e) {
        console.log($(e.currentTarget));
        Backbone.history.navigate("matches/" + $(e.currentTarget).attr('data-num'), true)
    }
});



var Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
        '(/)': 'indexShow',
        'disc(/)': 'discShow',
        'dash(/)': 'dashShow',
        'matches(/)': 'matchesShow',
        'matches/:id': 'matchShow',
        'friends(/)': 'friendsShow'
    },
    controller: {
        indexShow: function (param) {
            $.ajax({
                type: 'GET',
                url: window.location.origin + '/api/user/status',
                dataType: "json",
                success: function (data) {
                    Backbone.history.navigate("disc", true);
                },
                error: function (data) {
                    new IndexPage().render();
                }
            });
        },
        discShow: function (param) {
            new DisclaimerPage().render();
        },
        dashShow: function (param) {
            new DashPage().render();
        },
        matchesShow: function (param) {
            //new MatchesShow().render();

            var allMatchesView1 = new ahah({
                collection: matches,
                itemView: SampleView
            });
            allMatchesView1.render();
            var a = $(allMatchesView1.el);
            var allMatchesView2 = new ahah({
                itemView: Sample2View,
                collection: userMatches,
                template: a,
                itemViewContainer: 'ul#userNews'
            })
            console.log(allMatchesView2);
            allMatchesView2.render();
            console.log(5);

            region.show(allMatchesView2);
        },
        matchShow: function (param) {
            var obj = _.where(matches.models, {
                id: "" + param
            })[0].attributes;
            var m = new Match(obj);
            var y = new MatchView({
                model: m
            });
            y.render();
            region.show(y);
        },
        friendsShow: function (param) {

            var allUsersView1 = new FirendsCompos({
                collection: users,
                itemView: AllUsersView
            });
            //allUsersView1.render();
            //var b = $(allUsersView1.el).html();
            allUsersView1.render()

            $('#s').html(allUsersView1.el);


            var allUsersView2 = new FirendsCompos({
                itemView: MyPodView,
                collection: myUsers,
                template: '#s',
                itemViewContainer: 'ul#myFriends'
            })
            allUsersView2.render();

            $('#s2').html(allUsersView2.el);

            var allUsersView3 = new FirendsCompos({
                itemView: AllFriendsView,
                collection: myPod,
                template: '#s2',
                itemViewContainer: 'ul#myPod'
            })
            //allUsersView3.render();


            region.show(allUsersView3);
        }
    }
});



$(function () {
    app.start();
    new Router();
    Backbone.history.start({
        pushState: true
    });
});