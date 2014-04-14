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


/////                   MODELS 
///////////////////////////////
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
var OneNews = Backbone.Model.extend({
  defaults:{
        "id": "",
        "news": "",
        "date": ""
    }
})

/////               COLLECTIONS 
///////////////////////////////
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

var Matches = Backbone.Collection.extend({
    url: "/api/match",
    model: Match,
    parse: function (resp) {
        return resp.matches;
    }
});
var matches = new Matches();

var UserMatches = Backbone.Collection.extend({
    url: '/api/usermatch',
    model: UserMatch,
    parse: function (resp) {
        return resp.usermatches;
    }
});
var userMatches = new UserMatches();

var AllNews = Backbone.Collection.extend({
    url: 'api/user/news',
    model: OneNews,
    parse: function (resp) {
        return resp.news;
    }
});
var allNews = new AllNews();
var FirstNews = Backbone.Model.extend({initialize:function(){
  var that = this;
  this.model1 = this.get('model1');
}})
var AllUsers = Backbone.Model.extend({initialize:function(){
  var that = this;
  this.model1 = this.get('model1');
  this.model2 = this.get('model2');
  this.model3 = this.get('model3');
  this.model4 = this.get('model4');
  this.listenTo(this.model1, "add remove", function(){ that.trigger('change') });
  this.listenTo(this.model2, "add remove", function(){ that.trigger('change') });
  this.listenTo(this.model3, "add remove", function(){ that.trigger('change') });
  this.listenTo(this.model4, "add remove", function(){ that.trigger('change') });
}});
var AllMatches = Backbone.Model.extend({initialize:function(){
  var that = this;
  this.model1 = this.get('model1');
  this.model2 = this.get('model2');
  this.listenTo(this.model1, "add remove", function(){ that.trigger('change') });
  this.listenTo(this.model2, "add remove", function(){ that.trigger('change') });
}});


/////                     VIEWS  
///////////////////////////////

var MatchView = Backbone.Marionette.ItemView.extend({
    template: '#match',
    events: {
        'click button.btn.btn-outlined.btn-primary': 'addToMy',
        'touchstart button.btn.btn-outlined.btn-primary': 'addToMy'
    },

    addToMy: function (e) {
        e.preventDefault();
        var object = $('#matchForm').serializeObject()
        $.ajax({
            type: 'POST',
            url: window.location.origin + '/api/usermatch',
            dataType: "json",
            data: JSON.stringify({
                usermatch: object
            }),
            success: function (data) {
              userMatches.fetch({success: function(response) {
                Backbone.history.navigate("matches", true);
              }});
            },
            error: function (data) {
                alert('error');
                Backbone.history.navigate("matches", true);
            }
        });
        
}


});

var AllUsersView = Backbone.Marionette.ItemView.extend({
    template: '#usersView',
    events: {
      'click #myPod .icon.icon-plus.addIc': 'addToFr',
      'touchstart #myPod .icon.icon-plus.addIc': 'addToFr',
      'click a.tab-item': 'btnClick',
      'touchstart a.tab-item': 'btnClick',
      'click #allFriends .icon.icon-plus.addIc': 'addToFr',
      'touchstart #allFriends .icon.icon-plus.addIc': 'addToFr',
      'click #myFriends .icon.icon-close.delIc': 'remToFr',
      'touchstart #myFriends .icon.icon-close.delIc': 'remToFr'
    },
    addToFr: function(e){
      console.log('aadd')
      e.preventDefault();
      var num = $(e.currentTarget).attr('data-num');
      $.ajax({
        type: 'POST',
        url: window.location.origin+'/api/connection',
        dataType: "json", 
        data:JSON.stringify({"connection": {"user_id_2": num}}),
        success:function(data){
          console.log('suc')
          var mod = _.find(users.models, function(numb){ return _.contains(numb.attributes, num)  } )
          console.log(mod);
          users.remove(mod);
          myUsers.add(mod);
        },
        error:function(data){
         console.log(data);
         console.log('error') 
        }
      });
    },
    remToFr: function(e){
      console.log('reeem')
      e.preventDefault();
      var num = $(e.currentTarget).attr('data-num');
      $.ajax({
            type: 'DELETE',
            url: window.location.origin + '/api/connection/' + num,
            async: false,
            success: function (data) {
              users.fetch({silent:true,async:false});
              console.log('aaaaaassssss')
              myUsers.remove(_.where(myUsers.models, {
                id: "" + num
            }));
            },
            error: function (data) {
                alert('error');
                Backbone.history.navigate("friends", true);
            }
      });
    },
    btnClick: function (e) {
      console.log('DisclaimerPage222')
        e.preventDefault();
        if ($(e.currentTarget).attr('href')) {
          Backbone.history.navigate($(e.currentTarget).attr('href'), true)
        }
    },
    onShow: function(){
      this.listenTo(this.model, 'change', this.render);
    },
    onBeforeClose: function(){
        this.model.stopListening();
    }
  });

var AllMatchesView = Backbone.Marionette.ItemView.extend({
    template: '#matchesScreen',
    events: {
      'click #allMatches .icon.icon-plus.addIc': 'addToMyMatches',
      'touchstart #allMatches .icon.icon-plus.addIc': 'addToMyMatches',
      'click #userMatches .icon.icon-close.delIc': 'remFromMyMatches',
      'touchstart #userMatches .icon.icon-close.delIc': 'remFromMyMatches',
      'click a.tab-item': 'btnClick',
      'touchstart a.tab-item': 'btnClick'
    },
    addToMyMatches: function(e){
      console.log('aaaaaaaa');
      e.preventDefault();
      var num = $(e.currentTarget).attr('data-num');
      Backbone.history.navigate("matches/" + num, true)
    },
    remFromMyMatches: function(e){
      console.log('bbbbbbbbb');
      e.preventDefault();
      var num = $(e.currentTarget).attr('data-num');
      $.ajax({
            type: 'DELETE',
            url: window.location.origin + '/api/usermatch/'+num,
            async: false,
            success: function (data) {
              userMatches.remove(_.where(userMatches.models, {
                id: "" + num
              }))
            },
            error: function (data) {
                alert('error');
                Backbone.history.navigate("matches", true);
            }
      });
    },
    btnClick: function (e) {
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    },
    onShow: function(){
      this.listenTo(this.model, 'change', this.render);
    },
    onBeforeClose: function(){
        this.model.stopListening();
    }
  });


var DisclaimerPage = Backbone.Marionette.ItemView.extend({
    template: "#discPage",
    events: {
        'click a.tab-item': 'btnClick',
        'touchstart a.tab-item': 'btnClick',
        'click div.btn.btn-primary.btn-outlined': 'btnClick',
        'touchstart div.btn.btn-primary.btn-outlined': 'btnClick'
    },
    btnClick: function (e) {
      console.log('DisclaimerPage')
        e.preventDefault();
        Backbone.history.navigate($(e.currentTarget).attr('href'), true)
    }

});


var IndexPage = Backbone.Marionette.ItemView.extend({
    template: "#firstScreen",
    events: {
        'click a': 'firstScreenNav',
        'touchstart a': 'firstScreenNav'
    },

    firstScreenNav: function (e) {

        e.preventDefault();
        window.location = window.location.href + $(e.currentTarget).attr('href');
    }
});

var app = new Backbone.Marionette.Application();
app.addInitializer(function () {
            $.ajax({
                type: 'GET',
                url: window.location.origin + '/api/user/status',
                async:false,
                dataType: "json",
                success: function (data) {
matches.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        },async:false,silent:true
    });
    userMatches.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        },async:false,silent:true
    });
    users.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
        ,silent:true,async:false
    });
    myUsers.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
        ,silent:true,async:false
    });


    myPod.fetch({
        success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    ,silent:true,async:false});
    allNews.fetch({
      success: function (collection, response, options) {
            console.log('success')
        },
        error: function (collection, response, options) {
            console.log('error')
        }
    ,silent:true,async:false
    })

    allMatches = new AllMatches({model1:matches,model2:userMatches})
    allUsers = new AllUsers({model1:allNews,model2:myUsers,model3:myPod,model4:users});

                  app.login = true; 
                }
            });
    app.vent.on('firstNews',function(){
      firstNews = new AllNews(allNews.first(5));
      firstNewsMod = new FirstNews({model1:firstNews});
    })
    app.vent.trigger('firstNews');

});



var region = new Backbone.Marionette.Region({
    el: '#container'
});



var Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
        '(/)': 'indexShow',
        'disc(/)': 'discShow',
        'matches(/)': 'matchesShow',
        'matches/:id': 'matchShow',
        'friends(/)': 'friendsShow'
    },
    controller: {
        indexShow: function (param) {
          console.log('indexShow');
          if (app.login == true){
            Backbone.history.navigate("disc", true);
          }else {
            var a = new IndexPage();
            region.show(a);
          }
        },
        discShow: function (param) {
          var discPage = new DisclaimerPage({model:firstNewsMod});
          region.show(discPage);
        },
        matchesShow: function (param) {
          console.log('matchesShow');
            var allMatchesView = new AllMatchesView({model:allMatches});
            region.show(allMatchesView);
        },
        matchShow: function (param) {
          console.log('matchShow');
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
          console.log('friendsShow');
            var allUsersView = new AllUsersView({model:allUsers});
            region.show(allUsersView);
        }
    }
});



$(function () {
    new Router();
    app.start();
    Backbone.history.start({
       
    });
});