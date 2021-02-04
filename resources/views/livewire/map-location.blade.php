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
				<form wire:submit.prevent="createLocation">
					<div class="card-body">
						<div class="row">
							<div class="col-12">
						        @if (session()->has('message'))
						            <div class="alert alert-success">
						                {{ session('message') }}
						            </div>
						        @endif
							</div>
					    </div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Longtitude</label>
									<input wire:model="long" type="text" class="form-control">

									@error('long') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Latitude</label>
									<input wire:model="lat" type="text" class="form-control">

									@error('lat') <small class="text-danger">{{ $message }}</small> @enderror
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="">Title</label>
							<input wire:model="title" type="text" class="form-control">

							@error('title') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="form-group">
							<label for="">Description</label>
							<textarea wire:model="description" class="form-control"></textarea>

							@error('description') <small class="text-danger">{{ $message }}</small> @enderror
						</div>
						<div class="form-group">
							<label for="">Image</label>
							<div class="custom-file">
							    <input type="file" class="custom-file-input" wire:model="image">
							    <label class="custom-file-label" for="customFile">Choose file</label>
							</div>

							@error('image') <small class="text-danger">{{ $message }}</small> @enderror
							@if ($image)
								<img src="{{ $image->temporaryUrl() }}" width="300" height="300" class="mt-3">
							@endif
						</div>
						<div class="form-group">
							<button type="submit" class="form-control btn btn-primary">Submit Location</button>
						</div>
					</div>
				</form>
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

	  	// data dummy
	 //  	const geoJson = {
		//   "type": "FeatureCollection",
		//   "features": [
		//     {
		//       "type": "Feature",
		//       "geometry": {
		//         "coordinates": [
		//           "122.53408873456067",
		//           "-3.9903931292531922"
		//         ],
		//         "type": "Point"
		//       },
		//       "properties": {
		//         "message": "Mantap",
		//         "iconSize": [
		//           50,
		//           50
		//         ],
		//         "locationId": 30,
		//         "title": "Hello new",
		//         "image": "https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?ixid=MXwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80",
		//         "description": "Mantap"
		//       }
		//     },
		//     {
		//       "type": "Feature",
		//       "geometry": {
		//         "coordinates": [
		//           "122.54085870134793",
		//           "-3.999805210821549"
		//         ],
		//         "type": "Point"
		//       },
		//       "properties": {
		//         "message": "oke mantap Edit",
		//         "iconSize": [
		//           50,
		//           50
		//         ],
		//         "locationId": 29,
		//         "title": "Rumah saya Edit",
		//         "image": "https://images.unsplash.com/photo-1611855435748-0320fd485dd7?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=667&q=80",
		//         "description": "oke mantap Edit"
		//       }
		//     },
		//     {
		//       "type": "Feature",
		//       "geometry": {
		//         "coordinates": [
		//           "122.44769091304744",
		//           "-3.9714730861439733"
		//         ],
		//         "type": "Point"
		//       },
		//       "properties": {
		//         "message": "Update Baru",
		//         "iconSize": [
		//           50,
		//           50
		//         ],
		//         "locationId": 22,
		//         "title": "Update Baru Gambar",
		//         "image": "https://images.unsplash.com/photo-1611493056239-9f15dfe79373?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80",
		//         "description": "Update Baru"
		//       }
		//     },
		//     {
		//       "type": "Feature",
		//       "geometry": {
		//         "coordinates": [
		//           "122.51787588067884",
		//           "-4.020558659375311"
		//         ],
		//         "type": "Point"
		//       },
		//       "properties": {
		//         "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
		//         "iconSize": [
		//           50,
		//           50
		//         ],
		//         "locationId": 19,
		//         "title": "awdwad",
		//         "image": "https://images.unsplash.com/photo-1587554801471-37976a256db0?ixid=MXwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80",
		//         "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
		//       }
		//     }
		//   ]
		// }

		const loadLocations = (geoJson) => {
			geoJson.features.forEach((location) => {
				// destructuring dari location geoJson
				const {geometry, properties} = location;
				const {iconSize, locationId, title, image, description} = properties;

				let markerElement = document.createElement('div');
				markerElement.className = 'marker' + locationId;
				markerElement.id = locationId;
				markerElement.style.backgroundImage = 'url(https://docs.mapbox.com/help/demos/custom-markers-gl-js/mapbox-icon.png)';
				markerElement.style.backgroundSize = 'cover';
				markerElement.style.width = '40px';
				markerElement.style.height = '40px';

				const content = `<div style="overflow-y: auto; max-height: 400px; width: 100%">
								<table>
									<tbody>
										<tr>
											<td>Title</td>
											<td>${title}</td>
										</tr>
										<tr>
											<td>Picture</td>
											<td><img src="${image}" loading="lazy" width="100" height="100"></td>
										</tr>
										<tr>
											<td>Description</td>
											<td>${description}</td>
										</tr>
									</tbody>
								</table>
							</div>`;

				const popUp = new mapboxgl.Popup({
					offset: 25
				}).setHTML(content).setMaxWidth("400px");

				new mapboxgl.Marker(markerElement)
					.setLngLat(geometry.coordinates)
					.setPopup(popUp)
					.addTo(map);

			});
		}

		loadLocations({!! $geoJson !!});

		// load ulang data setelah ditambah location
		window.addEventListener('locationAdded', (e) => {
			loadLocations(JSON.parse(e.detail));
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
