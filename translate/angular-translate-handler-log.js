angular.module('pascalprecht.translate').factory('$translateMissingTranslationHandlerLog', [
  '$log',
  function ($log) {
    return function (translationId) {
      $log.warn('Translation for ' + translationId + ' doesn\'t exist');
      //$log.error('Translation for ' + translationId + ' doesn\'t exist');
    };
  }
]);