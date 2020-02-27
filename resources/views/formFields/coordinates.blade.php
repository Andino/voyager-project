<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
@php
    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
    $row = $dataTypeRows->where('field', 'ubicacion')->first();
    $options = $row->options;
    $showAutocomplete = property_exists($row->details, 'showAutocompleteInput') ? (bool)$row->details->showAutocompleteInput : true;
    $showAutocomplete = $showAutocomplete ? 'true' : 'false';
@endphp
<div id="coordinates-formfield">
    <coordinates
        inline-template
        ref="coordinates"
        api-key="AIzaSyDBVu7-1RUC6yikdaoWGGVj3ByGsONY3p0"
        :show-autocomplete="{{ $showAutocomplete }}"
        :show-lat-lng="false"
        :zoom="16"
    >
        <div>
            <div class="form-group">
                <div class="col-md-2" v-show="showLatLng">
                    <label class="control-label">{{ __('voyager::generic.latitude') }}</label>
                    <input
                        class="form-control"
                        type="number"
                        step="any"
                        name="{{ $row->field }}[lat]"
                        placeholder="19.6400"
                        v-model="lat"
                        @change="onLatLngInputChange"
                        v-on:keypress="onInputKeyPress($event)"
                    />
                </div>
                <div class="col-md-2" v-show="showLatLng">
                    <label class="control-label">{{ __('voyager::generic.longitude') }}</label>
                    <input
                        class="form-control"
                        type="number"
                        step="any"
                        name="{{ $row->field }}[lng]"
                        placeholder="-155.9969"
                        v-model="lng"
                        @change="onLatLngInputChange"
                        v-on:keypress="onInputKeyPress($event)"
                    />
                </div>

                <div class="clearfix"></div>
            </div>

            <div id="map"></div>
        </div>
    </coordinates>
</div>

@push('javascript')
    <script>
        Vue.component('coordinates', {
            props: {
                apiKey: {
                    type: String,
                    required: true,
                },
                showAutocomplete: {
                    type: Boolean,
                    default: true,
                },
                showLatLng: {
                    type: Boolean,
                    default: true,
                },
                zoom: {
                    type: Number,
                    required: true,
                }
            },
            data() {
                return {
                    autocomplete: null,
                    lat: '',
                    lng: '',
                    points: {
                    "lat": '13.707254', 
                    'lng': '-89.251156'
                    },
                    map: null,
                    marker: null,
                    onChangeDebounceTimeout: null,
                    place: null,
                };
            },
            mounted() {
                console.log("xd");
                let gMapScript = document.createElement('script');
                gMapScript.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC9xobjlaH8-UeY88tUVDW0hu9bq7tubF4&callback=gMapVm.$refs.coordinates.initMap&libraries=places');
                document.head.appendChild(gMapScript);
            },
            methods: {
                initMap: function() {

                    var vm = this;

                    // Set initial LatLng
                    var center = this.points;
                    this.setLatLng(center.lat, center.lng);

                    // Create map
                    vm.map = new google.maps.Map(document.getElementById('map'), {
                        zoom: vm.zoom,
                        center: new google.maps.LatLng(center.lat, center.lng)
                    });

                    // Create marker
                    vm.marker = new google.maps.Marker({
                        position: new google.maps.LatLng(center.lat, center.lng),
                        map: vm.map,
                        draggable: true
                    });

                    // Listen to map drag events
                    google.maps.event.addListener(vm.marker, 'drag', vm.onMapDrag);

                    // Setup places Autocomplete
                    if (this.showAutocomplete) {
                        vm.autocomplete = new google.maps.places.Autocomplete(document.getElementById('places-autocomplete'));
                        places = new google.maps.places.PlacesService(vm.map);
                        vm.autocomplete.addListener('place_changed', vm.onPlaceChange);
                    }
                },

                setLatLng: function(lat, lng) {
                    this.lat = lat;
                    this.lng = lng;
                },

                moveMapAndMarker: function(lat, lng) {
                    this.marker.setPosition(new google.maps.LatLng(lat, lng));
                    this.map.panTo(new google.maps.LatLng(lat, lng));
                },

                onMapDrag: function(event) {
                    console.log(event);

                    this.setLatLng(event.latLng.lat(), event.latLng.lng());

                    this.onChange('mapDragged');
                },

                onInputKeyPress: function(event) {
                    if (event.which === 13) {
                        event.preventDefault();
                    }
                },

                onPlaceChange: function() {
                    debugger;
                    this.place = this.autocomplete.getPlace();

                    if (this.place.geometry) {
                        this.setLatLng(this.place.geometry.location.lat(), this.place.geometry.location.lng());
                        this.moveMapAndMarker(this.place.geometry.location.lat(), this.place.geometry.location.lng());
                    }

                    this.onChange('placeChanged');
                },

                onLatLngInputChange: function(event) {
                    debugger;
                    this.moveMapAndMarker(this.lat, this.lng);
                    this.onChange('latLngChanged');
                },

                onChange: function(eventType) {
                    @if (property_exists($row->details, 'onChange'))
                        if (this.onChangeDebounceTimeout) {
                            clearTimeout(this.onChangeDebounceTimeout);
                        }

                        self = this
                        this.onChangeDebounceTimeout = setTimeout(function() {
                            {{ $row->details->onChange }}(eventType, {
                                lat: self.lat,
                                lng: self.lng,
                                place: self.place
                            });
                        }, 300);
                    @endif
                },
            }
        });

        var gMapVm = new Vue({ el: '#coordinates-formfield' });
    </script>
@endpush