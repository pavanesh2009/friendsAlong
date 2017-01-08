angular.module('faApp', ['smartTable.table','chieffancypants.loadingBar', 'ngAnimate','serverSide'])
  .config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
  })
  .controller('MainCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
    
    var getRandomSubreddit = function() {
      var sub = $scope.subreddits[Math.floor(Math.random() * $scope.subreddits.length)];
      // ensure we get a new subreddit each time.
      if (sub == $scope.subreddit) {
        return getRandomSubreddit();
      }
      return sub;
    };

    $scope.fetch = function() {
      $scope.subreddit = getRandomSubreddit();
      $http.jsonp('http://www.reddit.com/r/' + $scope.subreddit + '.json?limit=50&jsonp=JSON_CALLBACK').success(function(data) {
        $scope.posts = data.data.children;
      });
    };

     $scope.start = function() {
      cfpLoadingBar.start();
    };

    $scope.complete = function () {
      cfpLoadingBar.complete();
    }


    // fake the initial load so first time users can see it right away:
    $scope.start();
    $scope.fakeIntro = true;
    $timeout(function() {
      $scope.complete();
      $scope.fakeIntro = false;
    }, 750);


    //Writing for smart table

          $scope.rowCollection = [];

          $scope.columnCollection = [
                { label: 'First Name', map: 'FirstName', validationAttrs: 'required', validationMsgs: '<span class="error" ng-show="smartTableValidForm.FirstName.$error.required">Required!</span>' },
                { label: 'Last Name', map: 'LastName' },
                { label: 'User Name', map: 'UserName', validationAttrs: 'required' },
                { label: 'Password', map: 'Password', noList: true, editType: 'password' },
                { label: 'Customer', map: 'CustId', optionsUrl: '/GetCusts', editType: 'radio' },
                { label: 'Role', map: 'RoleId', optionsUrl: '/GetRoles', editType: 'select', defaultTemplate: '<option value="" ng-hide="dataRow[column.map]">---</option>', validationAttrs: 'required', validationMsgs: '<span class="error" ng-show="smartTableValidForm.RoleId.$error.required">Required!</span>' }, // NOTE: small hack which enables defaultTemplate option :)
                { label: 'E-mail', editType: 'email', map: 'Email' },
                { label: 'Cell Phone', map: 'Mobilephone', noEdit: true, validationAttrs: 'required' },
                { label: 'Locked', map: 'IsLocked', cellTemplate: '<input disabled type="checkbox" name="{{column.map}}" ng-model="dataRow[column.map]">', editType: 'checkbox', noAdd: true }
            ];

            $scope.globalConfig = {
                isPaginationEnabled: true,
                isGlobalSearchActivated: true,
                itemsByPage: 10,
                selectionMode: 'single',
                actions: {
                    list: { url: '/GetUsers' },
                    edit: { url: '/EditUser', title: 'Edit User', desc: 'Edit', iconClass: '' }, 
                    add: { url: '/AddUser', title: 'Add User', buttonClass: 'pull-right', iconClass: 'icon-plus', desc: ' Add User' }, // TODO: zkontrolovat default description
                    remove: { url: '/DelUser', title: 'Confirmation Dialog', msg: 'Do you really want to delete the user?' }
                }
            };

  });
