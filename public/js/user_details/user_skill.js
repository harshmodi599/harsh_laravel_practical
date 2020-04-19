$(document).ready(function(){
	$.noConflict();
	getSkill();
	function getSkill(){
		var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/user_details/user_skill",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user_name', name: 'user_name'},
            {data: 'email', name: 'email'},
            {data: 'mobile', name: 'mobile'},
            {data: 'gender', name: 'gender'},
            // {data: 'photo', name: 'photo'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });		
	}
});