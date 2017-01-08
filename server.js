'use strict';

// Imitation of server - for testing purpose
angular.module('serverSide', ['ngMockE2E'])
        .run(['$httpBackend', function ($httpBackend) {
            var users = [
            { "RoleId": 111, "UserId": 100849, "UserName": "pavanesh2009", "FirstName": "Pavanesh", "LastName": "Soni", "Email": "pavanesh2009@gmail.com", "Telephone": null, "Mobilephone": "9740352941", "Password": "mock", "CustCd": null, "CustId": 16, "Loccd": null, "IsLocked": true },
            { "RoleId": 463, "UserId": 100851, "UserName": "test", "FirstName": "User1", "LastName": "Test", "Email": "user@comp.com", "Telephone": null, "Mobilephone": "777111223", "Password": "pwd", "CustCd": null, "CustId": null, "Loccd": null, "IsLocked": false }];
            
            var roles = [{ "Text": "Sales Team", "Value": 463 }, { "Text": "Customer", "Value": 464 }, { "Text": "Admin", "Value": 465}];
            var custs = [{ "Text": "Company AAA", "Value": 15 }, { "Text": "Company BBB", "Value": 16}];

            $httpBackend.whenPOST('/GetRoles').respond(function (method, url, data, headers) {
                var result = [200];
                result.push({ data: roles })
                return result;
            });
            $httpBackend.whenPOST('/GetCusts').respond(function (method, url, data, headers) {
                var result = [200];
                result.push({ data: custs })
                return result;
            });
            $httpBackend.whenPOST('/GetUsers').respond(function (method, url, data, headers) {
                var result = [200];
                console.log("getting users now..");
                console.log("first users from mock DB : " + users[0].RoleId);
                result.push({ data: users })
                console.log("users will be : " + result);
                return result;
            });
            $httpBackend.whenPOST('/EditUser').respond(function (method, url, data, headers) {
                var updatedUser = angular.fromJson(data);
                for (var i = 0; i < users.length; i++)
                    if (updatedUser.UserId === users[i].UserId) {
                        angular.extend(users[i], updatedUser);
                        var result = [200];
                        result.push({ data: users[i] })
                        return result;
                    }
            });
            $httpBackend.whenPOST('/AddUser').respond(function (method, url, data, headers) {
                var newUser = angular.fromJson(data);
                users.push(newUser);

                var result = [200];
                result.push({ data: newUser })
                return result;
            });
            $httpBackend.whenPOST('/DelUser').respond(function (method, url, data, headers) {
                var updatedUser = angular.fromJson(data);
                for (var i = 0; i < users.length; i++)
                    if (updatedUser.UserId === users[i].UserId) {
                        users.splice(i, 1);
                        var result = [200];
                        result.push({ data: users[i] })
                        return result;
                    }
            });
        } ]);