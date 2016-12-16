

$(document).ready(function () {
    $(document).on('click', '.menu-item', function() { 
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
        var url = $('#'+formid).attr('action')
  
        $.ajax({
            type: 'POST',
            url: url,
            data: new FormData( $('#'+formid)[0] ),
            processData: false,
            contentType: false,
            success: function (data) {
                $('#my_dialog').html(data);
                $('#my_dialog').modal('show');
            }
        });
    });
	$(document).on('click', '.report-submit-button', function(e) { 
        e.preventDefault();
        var formid = $(this).attr('formid');
        var url = $('#'+formid).attr('action')
		var target = $(this).attr('target');
        $.ajax({
            type: 'POST',
            url: url,
            data: new FormData( $('#'+formid)[0] ),
            processData: false,
            contentType: false,
            success: function (data) {
               $('#' + target).html(data);
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
	
	$(document).on('click','.export-button',function(e){
		var jsonstring = $(this).attr('data');
		var csv = convertJSONtoCSV({
            data: jsonstring
        });
		
		if (csv == null) return;
		
		filename = $(this).attr('filename') || 'export.csv';

        if (!csv.match(/^data:text\/csv/i)) {
            csv = 'data:text/csv;charset=utf-8,' + csv;
        }
		
        data = encodeURI(csv);
		if($('#downloadFile').length == 0) {
			 $('<a></a>')
			.attr('id','downloadFile')
			.attr('href',data)
			.attr('download',filename)
			.appendTo('body');
		}
		else{
			$('#downloadFile')
			.attr('href',data)
			.attr('download',filename)
			.appendTo('body');
		}		
       

		$('#downloadFile').ready(function() {
			$('#downloadFile').get(0).click();
		});
		
		
	})
	
	function convertJSONtoCSV(args){
		args.data = JSON.parse(args.data);
		return convertArrayOfObjectsToCSV(args);
	}
	
	function convertArrayOfObjectsToCSV(args) {  
        var result, ctr, keys, columnDelimiter, lineDelimiter, data;
		
        data = args.data || null;
        if (data == null || !data.length) {
            return null;
        }
		
        columnDelimiter = args.columnDelimiter || ',';
        lineDelimiter = args.lineDelimiter || '\n';

        keys = Object.keys(data[0]);

        result = '';
        result += keys.join(columnDelimiter);
        result += lineDelimiter;
	
        data.forEach(function(item) {
            ctr = 0;
            keys.forEach(function(key) {
                if (ctr > 0) result += columnDelimiter;

                result += item[key];
                ctr++;
            });
            result += lineDelimiter;
        });
        return result;
    }

});
