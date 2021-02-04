<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;

class MapLocation extends Component
{
	use WithFileUploads;

	public $long, $lat, $title, $description, $image;
	public $geoJson;

	private function _loadLocations()
	{
		$locations = Location::orderBy('created_at', 'desc')->get();

		$resultLocations = [];
		foreach ($locations as $location) {
			$resultLocations[] = [
				'type' => 'Feature',
				'geometry' => [
					'coordinates' => [
						$location->long,
						$location->lat
					],
					'type' => 'Point',
				],
				'properties' => [
					'locationId' => $location->id,
					'title' => $location->title,
					'image' => asset('/storage/images') . '/' . $location->image,
					'description' => $location->description,
				]
			];
		}

		$geoLocation = [
			'type' => 'FeatureCollection',
			'features' => $resultLocations
		];

		$geoJson = collect($geoLocation)->toJson();
		$this->geoJson = $geoJson;
	}

	private function _clearForm()
	{
		$this->long = '';
		$this->lat = '';
		$this->title = '';
		$this->description = '';
		$this->image = '';
	}

	public function createLocation()
	{
		$this->validate([
			'long' => 'required',
			'lat' => 'required',
			'title' => 'required',
			'description' => 'required',
			'image' => 'required|image|max:2048'
		]);

		$image = md5($this->image.microtime()) . '.' . $this->image->extension();

		Storage::putFileAs(
			'public/images', // folder tempat simpan gambar
			$this->image, // filenya
			$image // namafilenya
		);

		Location::create([
			'long' => $this->long,
			'lat' => $this->lat,
			'title' => $this->title,
			'description' => $this->description,
			'image' => $image
		]);

		session()->flash('message', 'Post successfully added.');

		// clear form
		$this->_clearForm();
		// load ulang halamannya
		$this->_loadLocations();
		// load ulang datanya
		$this->dispatchBrowserEvent('locationAdded', $this->geoJson);

	}

    public function render()
    {
    	$this->_loadLocations();

        return view('livewire.map-location');
    }
}
