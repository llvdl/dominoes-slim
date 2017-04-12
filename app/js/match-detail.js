import Vue from 'vue';

$(function() {
    var currentAccountId = $('body').data('current-account');
    var matchId = $('body').data('match-id');

    var app = new Vue({
        el: '.container',
        data: {
            loaded: false,
            match: null,
            loggedIn: currentAccountId !== null,
            currentAccountId: currentAccountId
        }
    });

    var timeout = 2000;

    function testForRefresh() {

        $.get('/api/match/' + matchId)
            .done(function(data) {
                if (app.match === null || app.match.revision !== data.revision) {
                    app.match = data.match;
                    app.match['can_start'] = data.can_start;
                    app.loaded = true;
                }

                window.setTimeout(testForRefresh, timeout);
            });
    }

    testForRefresh();
})
