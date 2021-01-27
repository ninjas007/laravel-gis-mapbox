<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-dark text-white">
					MapBox
				</div>
				<div class="card-body">
					{{-- wire:ignore berfungsi agar ada update pada vue dia ga ngkut --}}
					<div wire:ignore id='map' style='width: 100%; height: 75vh;'></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Form
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
	</div>
</div>

@section('js')
<script>
	const defaultLocation = [122.51865058501699, -3.9863784815205605];

  	mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
  	var map = new mapboxgl.Map({
    	container: 'map',
    	center: defaultLocation,
    	zoom: 11.15
  	});

  	const style = "dark-v10";
  	
  	// custom style
  	map.setStyle(`mapbox://styles/mapbox/${style}`);
  	// tambah tombol zoom out dan zoom in
  	map.addControl(new mapboxgl.NavigationControl());

  	map.on('click', (e) => {
  		const longtitude = e.lngLat.lng;
  		const lattitude = e.lngLat.lat;

  		console.table({longtitude, lattitude})
  	});
</script>
@endsection
