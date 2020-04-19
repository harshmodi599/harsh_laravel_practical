$(document).ready(function(){
	$.noConflict();
	friendRequest();
	function friendRequest(){
		var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/user_details/friend_request_list",
            columns: [
                {data: 'first_name', name: 'first_name'},
                {data: 'photo', name: 'photo'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });		
	}
});