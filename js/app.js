(function($) {
    $.fn.toggleDisabled = function(){
        return this.each(function(){
            this.disabled = !this.disabled;
        });
    };
})(jQuery);
(function($) {
  $.fn.serializeObject = function()
  {
      var o = {};
      var a = this.serializeArray();
      $.each(a, function() {
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
    defaults: 
    {
      id:"",
      command_1:{
        id:"",
        name:"",
        image:""
      },
      command_2:{
        id:"",
        name:"",
        image:""
      },
      date:"",
      stadion:{
        name:"",
        lat:"",
        long:""
      }
    }
  }
);
var UserMatch = Backbone.Model.extend({
    defaults: 
    {
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
  }
);
var User = Backbone.Model.extend({
  defaults:
  {
    "id": "",
    "username": "",
    "password": "",
    "session_data": "",
    "created_at": "",
    "provider": "",
    "role": "",
    "status": ""
  }
})
var Users = Backbone.Collection.extend({
    url: "/api/user",
    model: User
});
var users = new Users();

var MyUsers = Backbone.Collection.extend({
    url: "/api/connection",
    model: User
});

var myUsers = new MyUsers();




var AllUsersView = Backbone.Marionette.ItemView.extend({
    template : '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var AllFriendsView = Backbone.Marionette.ItemView.extend({
    template : '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var MyPodView = Backbone.Marionette.ItemView.extend({
    template : '#oneUser',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});

var FirendsCompos = Backbone.Marionette.CompositeView.extend({
    template: '#usersView',
    
    itemViewContainer: 'ul#allFriends',
    events: {
      'click .icon.icon-plus.rig': 'addU',
      'touchstart .icon.icon-plus.rig': 'addU'
    },
    addU: function(e){
      console.log($(e.currentTarget));
    }
})


var MatchView = Backbone.Marionette.ItemView.extend({
  template: '#match',
  events: {
    'click button':'fu',
    'touchstart button': 'fu'
  },
  fu: function(e){
    e.preventDefault();
    //console.log(e);
      $.ajax({
          type: 'POST',
          url: window.location.origin+'/api/usermatch',
          dataType: "json", 
          data:JSON.stringify({usermatch:$('#matchForm').serializeObject()}),
          success: function(data){
            Backbone.history.navigate("disc",true);
          },
          error: function(data){
            new IndexPage().render();
          }
      });
      userMatches.fetch();
   
  }
})
var Matches = Backbone.Collection.extend({
    url: "/api/match",
    model: Match,
    parse:function(resp){
      return resp.matches;
    }
});

var UserMatches = Backbone.Collection.extend({
  url: '/api/usermatch',
  model: UserMatch,
  parse:function(resp){
      return resp.usermatches;
  }
});

var Friends = Backbone.Model.extend({
  defaults: {
    id_command1 : 'id_command1'
  }
});


var matches = new Matches();
var userMatches = new UserMatches();
var app = new Backbone.Marionette.Application();
app.addInitializer(function(){
  matches.fetch({
    success:function(collection, response, options){console.log('success')},
    error:function(collection, response, options){console.log('error')}
  });
  userMatches.fetch({
    success:function(collection, response, options){console.log('success')},
    error:function(collection, response, options){console.log('error')}
  });
  users.fetch({
    success:function(collection, response, options){console.log('success')},
    error:function(collection, response, options){console.log('error')}
  });
  myUsers.fetch({
    success:function(collection, response, options){console.log('success')},
    error:function(collection, response, options){console.log('error')}
  });
});

var IndexPage = Backbone.Marionette.ItemView.extend({
  template : "#firstScreen",
  el: '#container',
  events: {
    'click a' : 'firstScreenNav',
    'touchstart a' : 'firstScreenNav'
  },
  firstScreenNav: function(e){
    e.preventDefault();
    window.location = window.location.href + $(e.currentTarget).attr('href');
  }
});

var FriendsNews = Backbone.Model.extend({
})
var DisclaimerPage = Backbone.Marionette.ItemView.extend({
  template : "#discPage",
  el: '#container',
  events: {
    'click a' : 'btnClick',
    'click .btn': 'btnClick',
    'touchstart a' : 'btnClick'
  },
  btnClick: function(e){
    e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
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
    template : '#sample-template',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});
var Sample2View = Backbone.Marionette.ItemView.extend({
    template : '#sample2-template',
    tagName: 'li',
    className: 'table-view-cell btn-link'
});

var ahah = Backbone.Marionette.CompositeView.extend({
    template: '#matchesScreen',
    
    itemViewContainer: 'ul#news',
    events: {
      'click .icon.icon-plus.rig': 'addM',
      'touchstart .icon.icon-plus.rig': 'addM'
    },
    addM: function(e){
      console.log($(e.currentTarget));
      Backbone.history.navigate("matches/"+$(e.currentTarget).attr('data-num'),true)
    }
})


var MatchesShow = Backbone.Marionette.ItemView.extend({
  template : "#matchesScreen",
  el: '#container',
  events: {
    'click a.tab-item' : 'matchesPage',
    'touchstart a.tab-item': 'matchesPage',
    'touchstart .icon.icon-plus.rig':'addMatch'
  },
  matchesPage: function(e){
    e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
  },
  addMatch: function(e){
    console.log($(e.currentTarget));
    Backbone.history.navigate("matches/"+$(e.currentTarget).attr('data-num'),true)
  }
});

var Router = Backbone.Marionette.AppRouter.extend({
  appRoutes : {
    '(/)': 'indexShow',
    'disc(/)': 'discShow',
    'dash(/)': 'dashShow',
    'matches(/)': 'matchesShow',
    'matches/:id': 'matchShow',
    'friends(/)': 'friendsShow'
  },
  controller : {
    indexShow : function(param) {
      $.ajax({
          type: 'GET',
          url: window.location.origin+'/api/user/status',
          dataType: "json", 
          success: function(data){
            Backbone.history.navigate("disc",true);
          },
          error: function(data){
            new IndexPage().render();
          }
      });
    },
    discShow: function(param){
      new DisclaimerPage().render();
    },
    dashShow: function(param){
      new DashPage().render();
    },
    matchesShow: function(param){
      //new MatchesShow().render();
      var obj = new ahah({collection: matches,itemView: SampleView});
      obj.render()
      var obj2 = new ahah({
        itemView: Sample2View,
        collection: userMatches,
        template: obj.el,
        itemViewContainer: 'ul#userNews'
      })
      obj2.render();
      $('#container').html(obj2.el);
    },
    matchShow: function(param){
      var obj = _.where(matches.models,{id: ""+param})[0].attributes;
      console.log(obj);
      console.log('obj');
      var m = new Match(obj);
      console.log(m);
      var y = new MatchView({model:m});
      y.render();
      console.log(y);
      $('#container').html(y.el);
    },
    friendsShow: function(param){
      var obj = new FirendsCompos({collection: users,itemView: AllUsersView});
      obj.render()
      var obj2 = new FirendsCompos({
        itemView: AllFriendsView,
        collection: myUsers,
        template: obj.el,
        itemViewContainer: 'ul#myFriends'
      })
      obj2.render();

      $('#container').html(obj2.el);
    }
  }
});



$(function(){
  app.start();
  new Router();
  Backbone.history.start({pushState:true});
});

