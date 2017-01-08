var app = angular.module('PavaneshApp', []);

app.directive('country', function () {
return {
    restrict:"E",
    controller: function () {
        this.makeAnnouncement = function(message){
        console.log("Country says : " + message);
            }
        }
    }
});

app.directive('state', function () {
    return {
        restrict: "E",
        require:"^country",
        controller: function () {
            this.makeLaw = function(law){
                console.log("Country says : " + law);
            }
        },
        link :  function (scope, element, attrs, stateCtrl) {
            stateCtrl.makeAnnouncement("from state!!");
        }
    }
});

app.directive('city', function () {
return {
    restrict: "E",
    require: ["^country","^state"],
    link :  function (scope, element, attrs, ctrls) {
        //for only one require controller
        //countryCtrl.makeAnnouncement("This City rocks!!");
        ctrls[0].makeAnnouncement("from city");
        ctrls[1].makeLaw("Jump Higher, a state method being called from city by using POWER OF REQUIRE WITHIN DIRECTIVE");
        }
    }
});