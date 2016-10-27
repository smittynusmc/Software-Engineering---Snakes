

$(document).ready(function () {
    $('.menu-item').click(function (e) {
        var archo = $(this).attr('archo');
        var target = $(this).attr('target');
        $.ajax({
            type: 'POST',
            url:  archo,
            success: function (data) {
                $('#' + target).html(data);
            }
        });
    });
    $("#dialog").dialog({
        autoOpen: false
    });
    $('.function-button').click(function (e) {
        var achor = $(this).attr('archo');
        $.ajax({
            type: 'POST',
            url:  achor,
            success: function (data) {
                $('#my_dialog').html(data);
                $('#my_dialog').modal('show');
            }
        });
    });
    $(document).on('click', '.function-button', function() { 
        var achor = $(this).attr('archo');
        $.ajax({
            type: 'POST',
            url:  achor,
            success: function (data) {
                $('#my_dialog').html(data);
                $('#my_dialog').modal('show');
            }
        });
    });
    
    $(document).on('click', '.submit-button', function(e) { 
        e.preventDefault();
        var formid = $(this).attr('formid');
        var formdata = $('#'+formid).serialize();
        var url = $('#'+formid).attr('action')
        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            success: function (data) {
                $('#my_dialog').html(data);
                $('#my_dialog').modal('show');
            }
        });
    });
    
    $(document).on('click','.btn-loadrecord',function(e){
       e.preventDefault();
       $('#my_dialog').modal('hide');
       $('.modal-backdrop').remove();
       var achor = $(this).attr('archo');
       var target = $(this).attr('target');
       
       $.ajax({
            type: 'POST',
            url: achor,
            success: function (data) {
                
                $('#' + target).html(data);
                $('.modal-backdrop').remove();
            }
        });
       
    });
});