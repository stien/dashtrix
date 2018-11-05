(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

/********* Custom Validator Rules **********/

jQuery.validator.addMethod("requiredIfPresent", function (value, element, param) {
    return !isEmpty($(param).val());
}, function (param, element) {
    $param = $(param);
    $elem = $(element);
    return 'The field ' + $elem.prop('name') + ' needs to be filled if ' + $param.prop('name') + ' is present.';
});

// Helpers
function isEmpty(str) {
    return typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null || str.trim() === '';
}

},{}]},{},[1]);

//# sourceMappingURL=rules.js.map
