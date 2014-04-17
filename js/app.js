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
});
var OneMatch = Backbone.Model.extend({
  defaults:{
    "match":{
      "id":"",
      "command_1":{
        "id":"",
        "name":"",
        "img":""
      },
      "command_2":{
        "id":"",
        "name":"",
        "img":""
      },
      "date":"",
      "stadion":{
        "name":"",
        "lat":"",
        "long":""
      },
      "CountUserOnStadion":"",
      "CountFriendOnStadion":""
    }
  }
});


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
        'touchstart button.btn.btn-outlined.btn-primary': 'addToMy',
        'change input[name="type_place_viewing"]:radio' : 'toggleRadio',
        'click .backArr': 'back',
        'touchstart .backArr': 'back',
        'click .wi': 'navigate',
        'touchstart .wi': 'navigate'
        
    },
    toggleRadio:function(e){
            if ($('#home').prop("checked")){
              $('.inForm').find('input:radio').removeAttr('disabled');
              $('.inForm').slideDown();
            } else {
              $('.inForm').find('input:radio').attr('disabled','disabled');
              $('.inForm').slideUp();
            }
            if ($('#bar').prop("checked")){
              $('#bar').siblings('[name="place_viewing"]').removeAttr('disabled').slideDown();;
            } else {
              $('#bar').siblings('[name="place_viewing"]').attr('disabled','disabled').slideUp();
            }


            if ($('#stad').prop("checked")) {
                  $('#stad').siblings('[name="place_viewing"]').removeAttr('disabled');
                  var match = this.model.get('match');
                  var map_canv = $("#matchForm").find('#map_canvas')[0];
                  var myLatlng = new google.maps.LatLng(match.stadion.lat, match.stadion.long); // координаты
                  var myOptions = {
                      zoom: 16,
                      center: myLatlng,
                      panControl: false,
                      zoomControl: false,
                      scaleControl: false,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                  }
                  var map = new google.maps.Map(map_canv, myOptions); 
                  var contentString = '<p>Стадион '+match.stadion.name+"<br />"
                                      + "На стадионе смотрят матч " + match.CountUserOnStadion + " юзеров<br />"
                                      + "и " + match.CountFriendOnStadion + " друзей</p>";
                  var infowindow = new google.maps.InfoWindow({
                       content: contentString
                              
                  });
                  var marker = new google.maps.Marker({
                      position: myLatlng,
                      map: map,
                      icon: '/img/map_pin.png',
                      title: 'Нужный текст'
                  });
                  google.maps.event.addListener(marker, 'click', function() {
                      infowindow.open(map,marker);
                  });
                  $('#map_canvas').slideDown("slow",function(){
                    google.maps.event.trigger(map, "resize"); 
                    map.setCenter(myLatlng);
                  });
                  $('#stad').data('show',true);
                  
            } else {
              $('#stad').siblings('[name="place_viewing"]').attr('disabled','disabled');
              $('#map_canvas').slideUp();
            }
    },
    back:function(e){
      e.preventDefault();
      Backbone.history.navigate("matches", true);
    },
    navigate: function(e){
      e.preventDefault();
      Backbone.history.navigate($(e.currentTarget).attr('href'), true);
    },
    addToMy: function (e) {
        e.preventDefault();
        if($('#barName').val() == ""){
          $('#barName').addClass('nado');
          return;
        }
        var object = $('#matchForm').serializeObject();
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
      'click #myPod .table-view-cell': 'addToFr',
      'touchstart #myPod .table-view-cell': 'addToFr',
      'click a.tab-item': 'btnClick',
      'touchstart a.tab-item': 'btnClick',
      'click #allFriends .table-view-cell': 'addToFr',
      'touchstart #allFriends .table-view-cell': 'addToFr',
      'click #myFriends .table-view-cell': 'remToFr',
      'touchstart #myFriends .table-view-cell': 'remToFr',
      'click .icon.icon-share.logout': 'logOut',
      'touchstart .icon.icon-share.logout': 'logOut'
    },
    addToFr: function(e){
      var that = this;
      e.preventDefault();
      var num = $(e.currentTarget).find('.icon.icon-plus.addIc').attr('data-num');
      $.ajax({
        type: 'POST',
        url: window.location.origin+'/api/connection',
        dataType: "json", 
        data:JSON.stringify({"connection": {"user_id_2": num}}),
        success:function(data){
          var model = that.model.get('model4');
          var model2 = that.model.get('model2');
          console.log('suc')
          var mod = _.find(model.models, function(numb){ return _.contains(numb.attributes, num)  } )
          console.log(mod);
          model.remove(mod);
          model2.add(mod);
          that.model.trigger('change');
        },
        error:function(data){
         console.log(data);
         console.log('error') 
        }
      });
    },
    remToFr: function(e){
      var that = this;
      console.log('reeem')
      e.preventDefault();
      var num = $(e.currentTarget).find('.icon.icon-close.delIc').attr('data-num');
      $.ajax({
            type: 'DELETE',
            url: window.location.origin + '/api/connection/' + num,
            async: false,
            success: function (data) {
              var model = that.model.get('model4');
              var model2 = that.model.get('model2');
              model.fetch({silent:true,async:false});
              console.log('aaaaaassssss')
              model2.remove(_.where(model2.models, {
                id: "" + num
            }));
              that.model.trigger('change');
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
    logOut:function(){
      window.location = window.location.origin + "/api/user/logout";
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
      'click #allMatches .table-view-cell': 'addToMyMatches',
      'touchstart #allMatches .table-view-cell': 'addToMyMatches',
      'click #userMatches .table-view-cell': 'remFromMyMatches',
      'touchstart #userMatches .table-view-cell': 'remFromMyMatches',
      'click a.tab-item': 'btnClick',
      'touchstart a.tab-item': 'btnClick',
      'click .icon.icon-share.logout': 'logOut',
      'touchstart .icon.icon-share.logout': 'logOut'
    },
    addToMyMatches: function(e){
      e.preventDefault();
      console.log($(e.currentTarget));
      var num = $(e.currentTarget).find('.icon.icon-plus.addIc').attr('data-num');
      Backbone.history.navigate("matches/" + num, true)
    },
    remFromMyMatches: function(e){
      e.preventDefault();
      var that = this;
      var num = $(e.currentTarget).find('.icon.icon-close.delIc').attr('data-num');
      $.ajax({
            type: 'DELETE',
            url: window.location.origin + '/api/usermatch/'+num,
            async: false,
            success: function (data) {
              var models = that.model.get('model2');

              models.remove(models.get({
                id: "" + num
              }));
              that.model.trigger('change');
              //that.model.get('model2').trigger('add');
              //models.trigger('add');
              console.log(models);
            },
            error: function (data) {
                alert('error');
                Backbone.history.navigate("matches", true);
            }
      });
    },
    btnClick: function (e) {
        e.preventDefault();
        if ($(e.currentTarget).attr('href')) {
          Backbone.history.navigate($(e.currentTarget).attr('href'), true)
        }
    },
    logOut:function(){
      window.location = window.location.origin + "/api/user/logout";
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
        'touchstart div.btn.btn-primary.btn-outlined': 'btnClick',
        'click .icon.icon-share.logout': 'logOut',
        'touchstart .icon.icon-share.logout': 'logOut',
    },
    btnClick: function (e) {
      console.log('DisclaimerPage')
        e.preventDefault();
        if ($(e.currentTarget).attr('href')) {
          Backbone.history.navigate($(e.currentTarget).attr('href'), true)
        }
    },
    logOut:function(){
      window.location = window.location.origin + "/api/user/logout";
    }

});
var MapView = Backbone.Marionette.ItemView.extend({
    template: "#map",
    events: {
        'click a.tab-item': 'btnClick',
        'touchstart a.tab-item': 'btnClick',
        'click .icon.icon-left-nav.backArr': 'back',
        'touchstart .icon.icon-left-nav.backArr': 'back',
        'click .icon.icon-share.logout': 'logOut',
        'touchstart .icon.icon-share.logout': 'logOut',
        'click .btn.btn-outlined.btn-primary': 'showMap',
        'touchstart .btn.btn-outlined.btn-primary': 'showMap'
    },
    showMap: function(e){
      e.preventDefault();
      Backbone.history.navigate('map/'+$(e.currentTarget).attr('href'), true);
    },
    back: function(e){
      e.preventDefault();
      Backbone.history.navigate($(e.currentTarget).attr('href'), true);
    },
    btnClick: function (e) {
      console.log('MapView')
        e.preventDefault();
        if ($(e.currentTarget).attr('href')) {
          Backbone.history.navigate($(e.currentTarget).attr('href'), true)
        }
    },
    logOut:function(){
      window.location = window.location.origin + "/api/user/logout";
    },
    onShow: function(){
      this.$el.find('.backArr').attr('href',"matches/"+this.options.href);
      var match = this.model.get('match');
      console.log(match);
      console.log('match');
      var map_canv = this.$el.find('#cont')[0];
      console.log(map_canv);
      var myLatlng = new google.maps.LatLng(match.stadion.lat, match.stadion.long); // координаты
      var myOptions = {
          zoom: 16,
          center: myLatlng,
          panControl: false,
          zoomControl: false,
          scaleControl: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      console.log('1');
      var contentString = '<p>Стадион '+match.stadion.name+"<br />"
                          + "На стадионе смотрят матч " + match.CountUserOnStadion + " юзеров<br />"
                          + "и " + match.CountFriendOnStadion + " друзей</p>";
      var infowindow = new google.maps.InfoWindow({
           content: contentString
                  
      });
      console.log('2');
      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          icon: '/img/map_pin.png',
          title: 'Нужный текст'
      });
      console.log('3');
      google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
      });
      console.log('5');
      var map = new google.maps.Map(map_canv, myOptions);
      console.log('4');
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
        'matches/:id(/)': 'matchShow',
        'friends(/)': 'friendsShow',
        'map/:id(/)': 'mapShow',
        '*s':'toIndex'
    },
    controller: {
        indexShow: function (param) {
          console.log('indexShow');
          if (app.login == true){
            Backbone.history.navigate("matches", true);
          }else {
            var a = new IndexPage();
            region.show(a);
          }
        },
        toIndex: function(){
          Backbone.history.navigate("matches", true);
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
            $.ajax({
              type: 'GET',
              url: window.location.origin + '/api/match/'+param,
              async:false,
              dataType: "json",
              success: function (data) {
                console.log(data);
                var matchModel = new OneMatch(data);
                var matchView = new MatchView({model:matchModel});
                region.show(matchView);
              }
            })
        },
        friendsShow: function (param) {
            console.log('friendsShow');
            var allUsersView = new AllUsersView({model:allUsers});
            region.show(allUsersView);
        },
        mapShow: function(param){
            $.ajax({
              type: 'GET',
              url: window.location.origin + '/api/match/'+param,
              async:false,
              dataType: "json",
              success: function (data) {
                console.log(data);
                var matchModel = new OneMatch(data);
                var mapView= new MapView({model:matchModel,href:param});
                region.show(mapView);
              }
            })

        }
    }
});



$(function () {
    new Router();
    app.start();
    Backbone.history.start({
       
    });
});