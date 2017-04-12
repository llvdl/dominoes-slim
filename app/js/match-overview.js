import Vue from 'vue';

$(function() {
    var app = new Vue({
        el: '#match-overview',
        data: {
            loaded: false,
            matches: []
        }
    });

    $.get('/api/match')
        .done(function(matches) {
            app.loaded = true;
            app.matches = matches.length === 0 ? null : matches;
        });
})
