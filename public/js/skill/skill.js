$(document).ready(function(){
	$.noConflict();
	getData();
	function getData(){
		var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "skill/getData",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });		
	}
});