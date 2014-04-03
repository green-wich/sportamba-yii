$( document ).ready(function() {
    
    $('.matches').click(function () {
      allMatches2()
    });
    
});

function allMatches(){
    $.ajax({
        type: 'GET',
        url: apiURL+'/match',
        dataType: "json", // data type of response
        success: function(data){
            console.log( data );
        }
    });
}

function allMatches2(){
    $.ajax({
        type: 'POST',
        url: apiURL+'/user',
        dataType: "json", // data type of response
        success: function(data){
            console.log( data );
            window.location.reload();
        }
    });
}




var App = new (Backbone.View.extend({
    Models: {},
    Views: {},
    Collections: {},
    template: _.template($('#firstScreen').html()),
    evemts: {
        'click button.vk' : 'vklogin',
        'click button.fb' : 'fblogin'
    },
    render: function(){
        this.$el.html(this.template());
    },
    vklogin: function(){

    },
    fblogin: function(){

    },
    start: function(){
        Backbone.history.start({pushState: true})
    }
}))({el : document.body})




App.Models.Match = Backbone.Model.extend({
    defaults: {
        id : 'id',
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

App.Collections.Matches = Backbone.Collection.extend({
    model : App.Models.Match
});

App.Views.MatcheView = Backbone.View.extend({
    model: App.Models.Match,
    template: _.template($('#matchScreen').html()),
    render: function(){
        this.$el.html(this.template(this.model.atributes));
        return this;
    }

})


App.Models.Command = Backbone.Model.extend({
    defaults: {
        name : 'name',
        description : 'description',
        img : 'img'
    }
})





App.Models.User = Backbone.Model.extend({
    id : 'id',
    username : 'username',
    password : 'password',
    created_at : 'created_at',
    status : 'status'
})

App.Router = Backbone.Router.extend({
    routes : {
        "" : "start"
    },
    start : function(){
        console.log('start')
    }
})

var UserMatches = Backbone.Collection.extend({
    model : App.Models.Match
})
$(function(){
    App.render();
    App.start();
})