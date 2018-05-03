<div id="map"></div>
<style>
	/* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
	#map {
		height: 95%;
	}

	/* Optional: Makes the sample page fill the window. */
	html, body {
		height: 100%;
		margin: 0;
		padding: 0;
	}
</style>
<script>
	function initMap() {
		let infoWindow;
		let arr = [];
		<?php /** @var array $clusters */
		for($i = 0; $i < count($clusters); $i++): ?>
		<?php $cluster = $clusters[$i] ?>
		arr[<?php echo $i ?>] = {
			id: <?php echo $cluster->id ?>,
			Building: '<?php echo $cluster->Building ?>',
			Description: '<?php echo $cluster->Description ?>',
			Latitude: <?php echo $cluster->Latitude ?>,
			Longitude: <?php echo $cluster->Longitude ?>,
			NumFood: <?php echo $cluster->NumFood ?>,
			NumDrink: <?php echo $cluster->NumDrink ?>,
			NumCoffee: <?php echo $cluster->NumCoffee ?>,
			Content: '<a href="/index.php/clusters/viewCluster/<?php echo $cluster->id ?>">' +
			'<h1><?php echo $cluster->Building ?></h1><br><h2><?php echo $cluster->Description?>' +
			'</h2><p><br>Snack Machines: <?php echo $cluster->NumFood?><br>Drink Machines: <?php echo
			$cluster->NumDrink ?><br>Coffee Machines: <?php echo $cluster->NumCoffee ?></p></a>'
		};
		<?php endfor; ?>

		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 17,
			center: {lat: 35.307, lng: -80.734}
		});
		for (let i = 0; i < arr.length; i++) {
			let marker = new google.maps.Marker({
				position: {lat: arr[i].Latitude, lng: arr[i].Longitude},
				map: map
			});
			marker.addListener('click', function () {
				infoWindow = new google.maps.InfoWindow({
					content: arr[i].Content
				});
				infoWindow.open(map, marker);
			});
		}

		let userLocation = new google.maps.InfoWindow();

		// Try HTML5 geolocation.
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};

				userLocation.setPosition(pos);
				userLocation.setContent('You Are Here');
				userLocation.open(map);
				map.setCenter(pos);
			}, function () {
				handleLocationError(true, userLocation, map.getCenter());
			});
		} else {
			// Browser doesn't support Geolocation
			handleLocationError(false, userLocation, map.getCenter());
		}
	}

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
			'Error: The Geolocation service failed.' :
			'Error: Your browser doesn\'t support geolocation.');
		infoWindow.open(map);
	}
</script>
<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_gkMmgchWRJw8AYEcsOaEeJGZnoXA9KY&callback=initMap">
</script>
