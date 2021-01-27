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
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Longtitude</label>
								<input wire:model="long" type="text" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Latitude</label>
								<input wire:model="lat" type="text" class="form-control">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('js')
<script>
	{{-- load dulu livewire baru jalankan scriptnya --}}
	document.addEventListener('livewire:load', () => {
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

	  		// kirim data ke properti long di MapLocation.php
	  		@this.long = longtitude;
	  		@this.lat = lattitude;
	  	});
	});
</script>
@endsection
