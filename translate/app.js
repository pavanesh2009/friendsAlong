var app = angular.module('myApp', ['pascalprecht.translate']);

app.config(['$translateProvider', function ($translate) {
  $translate.preferredLanguage('en');
  $translate.useMissingTranslationHandlerLog();
    
  $translate.translations('en', {
    HEADLINE: 'I\'m a headline',
    BUTTON_LANG_EN: 'english',
    BUTTON_LANG_DE: 'german'
  });

  $translate.translations('de', {
    HEADLINE: 'Ich bin eine Überschrift',
    BUTTON_LANG_EN: 'englisch', 
    BUTTON_LANG_DE: 'deutsch'
  });
}]);


app.factory('$translateMissingTranslationHandlerLog', [
  '$log',
  function ($log) {
    return function mona(translationId) {     
      //$log.warn('Translation for ' + translationId + ' doesn\'t exist');  
      return translationId;               
    };
  }
]);

app.controller('Ctrl', ['$translateMissingTranslationHandlerLog','$translate', '$scope', function ($translateMissingTranslationHandlerLog,$translate, $scope) {
    
   //console.log($translateMissingTranslationHandlerLog);
  // $scope.missedTextKey = $translateMissingTranslationHandlerLog;
    console.log(" foo : " ,  $translate.useMissingTranslationHandlerLog);
 console.log("$translateMissingTranslationHandlerLog : ", $translateMissingTranslationHandlerLog());
  $scope.changeLanguage = function (langKey) {
    console.log("User changed language to : " , langKey);
    $translate.uses(langKey);
  }; 
  
}]);
 