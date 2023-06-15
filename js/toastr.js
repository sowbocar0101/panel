/*
Template Name: Monster Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
     "use strict";
       $(".tst1").click(function(){
            $.toast({
             heading: 'Welcome to Monster admin',
             text: 'Use the predefined ones, or specify a custom position object.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'info',
             hideAfter: 3000, 
             stack: 6
           });
 
      });
 
       $(".tst2").click(function(){
            $.toast({
             heading: 'Welcome to Monster admin',
             text: 'Use the predefined ones, or specify a custom position object.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500, 
             stack: 6
           });
 
      });
       $(".tst3").click(function(){
            $.toast({
             heading: 'Welcome to Monster admin',
             text: 'Use the predefined ones, or specify a custom position object.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'success',
             hideAfter: 3500, 
             stack: 6
           });
 
      });
 
       $(".tst4").click(function(){
            $.toast({
             heading: 'Welcome to Monster admin',
             text: 'Use the predefined ones, or specify a custom position object.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'error',
             hideAfter: 3500
             
           });
 
      });
 });
 
 function showInfo(){
      $.toast({
       heading: 'Notification',
       text: 'Welcome to the administration.',
       position: 'top-right',
       loaderBg:'#ff6849',
       icon: 'info',
       hideAfter: 3000, 
       stack: 6
     });
   }
 
 function showWarning(){
      $.toast({
       heading: 'Notification',
       text: 'Ongoing treatment.',
       position: 'top-right',
       loaderBg:'#ff6849',
       icon: 'warning',
       hideAfter: 3500, 
       stack: 6
     });
 }
 
 function showWarningIncorrect(msg){
      $.toast({
           heading: 'Notification',
           text: msg,
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'warning',
           hideAfter: 3500, 
           stack: 6
      });
 }
 function showSuccess(msg){
      $.toast({
           heading: 'Notification',
           text: msg,
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'success',
           hideAfter: 3500, 
           stack: 6
      });
 }
 function showFailed(msg){
      $.toast({
      heading: 'Notification',
      text: msg,
      position: 'top-right',
      loaderBg:'#ff6849',
      icon: 'error',
      hideAfter: 3500
      });
 }
 