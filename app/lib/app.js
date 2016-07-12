var app = angular.module('taskListApp', ['ui.bootstrap']).config(['$httpProvider', function($httpProvider) {
    //Setting headers
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest";
    // $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=_token]').attr('content');
}]).constant('APIURL', '/');