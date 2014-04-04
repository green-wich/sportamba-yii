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

var Matches = Backbone.Collection.extend({
    url: "/api/match",
    model: Match,
    parse:function(resp){
      return resp.matches;
    }
});

var Friends = Backbone.Model.extend({
  defaults: {
    id_command1 : 'id_command1'
  }
});


var matches = new Matches();
var app = new Backbone.Marionette.Application();
app.addInitializer(function(){
  matches.fetch({
    success:function(collection, response, options){console.log('success')},
    error:function(collection, response, options){console.log('error')}
  })
});

var IndexPage = Backbone.Marionette.ItemView.extend({
  template : "#firstScreen",
  el: '#container',
  events: {
    'click a' : 'firstScreenNav'
  },
  firstScreenNav: function(e){
    e.preventDefault();
    window.location = window.location.href + $(e.currentTarget).attr('href');
  }
});


var DisclaimerPage = Backbone.Marionette.ItemView.extend({
  template : "#discPage",
  el: '#container',
  events: {
    'click a' : 'discPage',
    'click .btn': 'btnClick'
  },
  discPage: function(e){
    e.preventDefault();
    Backbone.history.navigate($(e.currentTarget).attr('href'),true)
  },
    btnClick: function(e){
      Backbone.history.navigate($(e.currentTarget).attr('href'),true)
    }
});


OneItemView = Backbone.Marionette.ItemView.extend({
  template: "#row-template"
});

TableView = Backbone.Marionette.CompositeView.extend({
  itemView: OneItemView,
  // specify a jQuery selector to put the itemView instances in to
  itemViewContainer: "ul#news",
  template: "#matchesScreen"
});


var SampleView = Backbone.Marionette.ItemView.extend({
    template : '#sample-template',
    tagName: 'div'
});

var ahah = Backbone.Marionette.CompositeView.extend({
    template: '#matchesScreen',
    itemView: SampleView,
    itemViewContainer: 'ul#news'
})

var obj = new ahah({collection: matches});
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
      obj.render()
      $('#container').html(obj.el);
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

