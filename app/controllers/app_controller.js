app.controller('taskListController', function($scope, $http, $uibModal, APIURL){

	$scope.taskStates = [
        {state : "New"},
        {state : "In Progress"},
        {state : "Finished"}
    ];

	$scope.animationsEnabled = true;

	$scope.open = function (modalstate, taskID, size) {
		switch (modalstate) {
            case 'delete':
                var modalInstance = $uibModal.open({
			    	animation: $scope.animationsEnabled,
			      	templateUrl: 'delete.html',
			      	controller: 'ModalDeleteController',
			      	size: size,

			      	resolve: {			        	
			        	taskID: function () {
			          		return taskID;
			        	},
			        	APIURL: function () {
			          		return APIURL;
			        	}
			      	}
			    }); //end modalInstance
                break;
            case 'delete_user':
                userID = taskID;
                var modalInstance = $uibModal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'delete_user.html',
                    controller: 'ModalDeleteUserController',
                    size: size,

                    resolve: {                      
                        userID: function () {
                            return userID;
                        },
                        APIURL: function () {
                            return APIURL;
                        }
                    }
                }); //end modalInstance
                break;
            case 'edit':
                var modalInstance = $uibModal.open({
			    	animation: $scope.animationsEnabled,
			      	templateUrl: 'changestate.html',
			      	controller: 'ModalStateController',
			      	size: size,

			      	resolve: {
			        	taskStates: function () {
			          		return $scope.taskStates;
			        	},
			        	taskID: function () {
			          		return taskID;
			        	},
			        	APIURL: function () {
			          		return APIURL;
			        	}
			      	}
			    }); //end modalInstance
                break;
            default:
                break;
        }
	    
	  };//end open	

});//End Controller

app.controller('ModalStateController', function ($scope, $http, $uibModalInstance, taskStates, taskID, APIURL) {

	$scope.taskStates = taskStates;
	var url = APIURL+'state/'+taskID;
	
	//On submit, update task state and reload the page on success
 	$scope.submit = function () {
  		$http({
            method: 'POST',
            url: url,
            data: {newstate:$scope.stateoptions.state,taskID:taskID},
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
        	location.reload();
        },function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please contact your web administrator');
        });

    	$uibModalInstance.close();
  	};

  	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
  	};
});


app.controller('ModalDeleteController', function ($scope, $http, $uibModalInstance, taskID, APIURL) {

	var url = APIURL+'tasks/delete/'+taskID;

	//On Yes, delete task and reload the page on success
 	$scope.delete = function () {
  		$http({
            method: 'POST',
            url: url,
            data: {taskID:taskID},
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
        	location.reload();
        },function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please contact your web administrator');
        });

    	$uibModalInstance.close();
  	};

  	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
  	};
});

app.controller('ModalDeleteUserController', function ($scope, $http, $uibModalInstance, userID, APIURL) {

    var url = APIURL+'admin/user/delete/'+userID;

    //On Yes, delete task and reload the page on success
    $scope.delete_user = function () {
        $http({
            method: 'POST',
            url: url,
            data: {userID:userID},
            headers: {'Content-Type': 'application/json'}
        }).then(function(response) {
            location.reload();
        },function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please contact your web administrator');
        });

        $uibModalInstance.close();
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

