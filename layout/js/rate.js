$(function(){
    $("#rateYo").rateYo({
       fullStar:true,
       onSet: function(rating, rateYolnstance){
           $("#rating").val(rating);
       }

    });


   
});