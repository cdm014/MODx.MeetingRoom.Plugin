<script>
$(document).ready(function() {
	$("#requestdiv").append('<h1>Reservations</h1><label for="start">From:</label><input name="start" id="startdate" />');
	$("#startdate").datepicker({
		dateFormat: 'yy-mm-dd'
		,onSelect: function () {
			updateTable();
		}
		
		
	});
	$("#requestdiv").append('<label for="end">Until:</label><input name="end" id="enddate" />');
	$("#enddate").datepicker({
		dateFormat: 'yy-mm-dd'
		,onSelect: function () {
			updateTable();
		}
		
	});
	$("#requestdiv").append('<label for="room">Meeting Room: </label><select id="room" name="room" width="30"></select>');
	
	$.ajax({
		url: '/branches/roomlist.js'
		,dataType: 'json'
		,data: {
			type: 'room'
		}
		,success: function(data) {
			$("#roomTable").remove();
			$("#requestdiv").prepend('<h1>Available Meeting Rooms</h1><table id="roomTable"></table>');
			
			$("#roomTable").html('<thead><tr><th>Room Name</th><th>Address</th><th>Description</th></tr></thead>');
			
			
			for (x in data) {
				var room = data[x];
				$("#roomTable").append('<tr><td>'+room.name+'</td><td>'+room.address+'</td><td>'+room.description+'</td></tr>');
				$("#room").append('<option value="'+room.id+'">'+room.name+'</option>');
			}
			$("#room").width($("#room").width());
		}
	});
	$("#room").on("change", updateTable);
	
	
	
});

function updateTable() {
	$.ajax({
		url: '/branches/requestlist.js'
		,type: 'POST'
		,data: {
			start: $("#startdate").val()
			,end: $("#enddate").val()
			,room: $("#room").val()
			,test: "test"
		}
		,success: function(data) {
			var test = eval(data);
			//alert(data);
			var m_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			$("#requestTable").remove();
			$("#requestdiv").append('<table id="requestTable"></table>');
			$("#requestTable").html('<thead><tr><th>Date</th><th>From</th><th>To</th><th>Reserved By</th></tr></thead>');
			for (x in test) {
				var startsplit = test[x].start.split(' ');
				var endsplit = test[x].end.split(' ');
				var date = new Date (startsplit[0]);
				var dateString = m_names[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();
				$("#requestTable").append('<tr><td>'+dateString+'</td><td>'+startsplit[1]+'</td><td>'+endsplit[1]+'</td><td>'+test[x].group+'</td></tr>');
			}
			
		}
	});
}
updateTable();


</script>