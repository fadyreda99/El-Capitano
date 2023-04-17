$(function (){
    'use strict';

//switch between login & signup forms
$('.login-page h1 span').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);
})

    //confirmation message on delete
    $('.confirm').click(function(){
        return confirm('Are You Sure?');
    });




});