<script>
$(document).ready(function() {
	$("#requestdiv").append('<h1>Reservations</h1><label for="start">From:</label><input name="start" id="startdate" />');
	$("#startdate").datepicker({
		dateFormat: 'yy-mm-dd'
		
		
	});
	$("#requestdiv").append('<label for="end">Until:</label><input name="end" id="enddate" />');
	$("#enddate").datepicker({
		dateFormat: 'yy-mm-dd'
		
		
	});
	$("#requestdiv").append('<label for="room">Meeting Room: </label><select id="room" name="room" width="300"></select>');
	
	$.ajax({
		url: '/branches/roomlist.js'
		,dataType: 'json'
		,data: {
			type: 'room'
		}
		,success: function(data) {
			$("#roomTable").remove();
			$("#requestdiv").prepend('<h1>Available Meeting Rooms</h1><table id="roomTable"></table>');
			
			$("#roomTable").html('<thead><tr><th>Room Name</th><th>Address</th></tr></thead>');
			for (x in data) {
				var room = data[x];
				$("#roomTable").append('<tr><td>'+room.name+'</td><td>'+room.address+'</td></tr>');
				$("#room").append('<option value="'+room.id+'">'+room.name+'</option>');
			}
		}
	});
});

function updateTable() {
	$.ajax({
		url: '/branches/requestlist.js'
		,success: function(data) {
			var test = eval(data);
			//alert(data);
			$("#requestTable").remove();
			$("#requestdiv").append('<table id="requestTable"></table>');
			$("#requestTable").html('<thead><tr><th>From</th><th>To</th><th>Reserved By</th></tr></thead>');
			for (x in test) {
				$("#requestTable").append('<tr><td>'+test[x].start+'</td><td>'+test[x].end+'</td><td>'+test[x].group+'</td></tr>');
			}
			
		}
	});
}
updateTable();
</script>