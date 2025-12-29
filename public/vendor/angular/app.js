var module=angular.module('bbnsms',['ui.router']);


module.config(['$stateProvider','$urlRouterProvider',function($stateProvider, $urlRouterProvider){

    $stateProvider.state('home',{
        url:'/home',
        templateUrl:'pages/home-content.php',
        controller:'homeController'
    });

    $stateProvider.state('sent',{
        url:'/home',
        templateUrl:'pages/sent-content.php',
        controller:'sentController'
    });

    $stateProvider.state('drafts',{
        url:'/home',
        templateUrl:'pages/drafts-content.php',
        controller:'sentController'
    });

    $stateProvider.state('settings',{
        url:'/home',
        templateUrl:'pages/settings-content.php',
        controller:'sentController'
    });

    // $urlRouterProvider.otherwise('/home');
}]);



module.controller('homeController',['$scope','$state','$stateParams',function($scope){


    // $scope.updateTask=function(task){
    //     dataService.updateTask(task);
    // };
    $scope.sent = function(){
        $state.go('sent');
    }


}]);

module.controller('sentController',['$scope','$state','$stateParams',function($scope){


    // $scope.updateTask=function(task){
    //     dataService.updateTask(task);
    // };
    $scope.sent = function(){
        // $state.transitionTo('sent',$stateParams,{reload:true});
        $state.go('sent');
    }

}]);

module.controller('draftsController',['$scope','$state','$stateParams',function($scope){


    // $scope.updateTask=function(task){
    //     dataService.updateTask(task);
    // };

}]);

module.controller('settingsController',['$scope','$state','$stateParams',function($scope){


    // $scope.updateTask=function(task){
    //     dataService.updateTask(task);
    // };

}]);
