$(document).ready(function(){
	$.noConflict();
	friendList();
	function friendList(){
		var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/user_details/friend_list",
        columns: [
            {data: 'first_name', name: 'first_name'},
            {data: 'photo', name: 'photo'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });		
	}
});