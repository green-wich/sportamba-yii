var Match = Backbone.Model.extend({
  defaults: {
    id_command1 : 'id_command1',
    id_command2 : 'id_command2',
    date : 'date',
    status : 'status',
    url : 'url',
    title : 'title',
    text : 'text',
    img : 'img'
  }
});

var Friends = Backbone.Model.extend({
  defaults: {
    id_command1 : 'id_command1',
    id_command2 : 'id_command2',
    date : 'date',
    status : 'status',
    url : 'url',
    title : 'title',
    text : 'text',
    img : 'img'
  }
});

var Matches = Backbone.Collection.extend({
    model: Match
});

var matches = new Matches();

var app = new Backbone.Marionette.Application();

app.addInitializer(function(){
  matches.add([{    
    id_command1 : '111111',
    id_command2 : '111111',
    date : '11111',
    status : '111111',
    url : '111111',
    title : '111111',
    text : '111111',
    img : '111111'},{    
    id_command1 : '2222222',
    id_command2 : '2222222',
    date : '2222222',
    status : '2222222',
    url : '2222222',
    title : '2222222',
    text : '2222222',
    img : '2222222'}],{parse:true});
});



var IndexPage = Backbone.Marionette.ItemView.extend({
  template : "#firstScreen",
  el: '#container',
  events: {
    'click a' : 'firstScreenNav'
  },
  firstScreenNav: function(e){
    window.location = window.location.href + $(e.currentTarget).attr('href');
  }
});

var DisclaimerPage = Backbone.Marionette.ItemView.extend({
  template : "#discPage",
  el: '#container',
  events: {
    'click a' : 'discPage'
  },
  discPage: function(e){
     e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
  }
});

var DashPage = Backbone.Marionette.ItemView.extend({
  template : "#dashPage",
  el: '#container',
  events: {
    'click a.tab-item' : 'dashPage'
  },
  dashPage: function(e){
    e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
  }
});

var MatchesShow = Backbone.Marionette.ItemView.extend({
  template : "#matchesScreen",
  el: '#container',
  events: {
    'click a.tab-item' : 'matchesPage'
  },
  matchesPage: function(e){
     e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
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
        url: 'http://sportamba-yii.loc/api/user/status',
        dataType: "json", // data type of response
        success: function(data){
            if (data == 1){
              Backbone.history.navigate("disc",true)
            } else {
              new IndexPage().render();
            }
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
      new MatchesShow().render();
    },
    matchShow: function(param){
      var id = Matches.get(param);
      new MatchShow(id).render();
    },
    friendsShow: function(param){

    }
  }
});



$(function(){
  app.start();
  new Router();
  Backbone.history.start({pushState:true});
});

