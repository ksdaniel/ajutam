<template>
  <div style="height: 400px">
    <div id="map_647fa6b4730c4f3e973f4d3a0821b5b5" class="folium-map" />
  </div>
</template>

<script>
export default {
  name: 'ClujMap',
  props: ['geojson'],

  data(){
    return {
      drawnItems: false,
      mapObj: false,

    };
  },

  watch: {

    geojson(val){
      if (val){
        var geojson = L.geoJSON(val, {
          onEachFeature: (f, l) => {
            // l.bindPopup('');

            this.drawnItems.addLayer(l);
          },

        });
      }
    },

  },

  mounted(){
    this.mapObj = L.map(
      'map_647fa6b4730c4f3e973f4d3a0821b5b5',
      {
        center: [46.769564, 23.589459],
        crs: L.CRS.EPSG3857,
        zoom: 12,
        zoomControl: true,
        preferCanvas: false,
      }
    );

    const tile_layer_4e047998d13d453aaae0b8f846dcfb38 = L.tileLayer(
      'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      { 'attribution': 'Data by \u0026copy; \u003ca href="http://openstreetmap.org"\u003eOpenStreetMap\u003c/a\u003e, under \u003ca href="http://www.openstreetmap.org/copyright"\u003eODbL\u003c/a\u003e.', 'detectRetina': false, 'maxNativeZoom': 18, 'maxZoom': 18, 'minZoom': 0, 'noWrap': false, 'opacity': 1, 'subdomains': 'abc', 'tms': false }
    ).addTo(this.mapObj);

    const options = {
      position: 'topleft',
      draw: {},
      edit: {},
    };
    // FeatureGroup is to store editable layers.
    this.drawnItems = new L.featureGroup().addTo(
      this.mapObj
    );

    options.edit.featureGroup = this.drawnItems;
    const draw_control_fa0e8edf6dff4b2ab899e4c3c05e9b28 = new L.Control.Draw(
      options
    ).addTo(this.mapObj);

    this.mapObj.on(L.Draw.Event.CREATED, (e) => {
      const layer = e.layer,
        type = e.layerType;
      const coords = JSON.stringify(layer.toGeoJSON());
      layer.on('click', function() {
        alert(coords);
        console.log(coords);
      });
      this.drawnItems.addLayer(layer);
    });

    this.mapObj.on('draw:created', (e) => {
      this.drawnItems.addLayer(e.layer);
    });

    // document.getElementById('export').onclick = function(e) {
    //   var data = drawnItems.toGeoJSON();
    //   var convertedData = 'text/json;charset=utf-8,' +
    //                 encodeURIComponent(JSON.stringify(data));
    //   document.getElementById('export').setAttribute(
    //     'href', 'data:' + convertedData
    //   );
    //   document.getElementById('export').setAttribute(
    //     'download', 'data.geojson'
    //   );
    // };
  },

  methods: {
    getGeoJSON(){
      return this.drawnItems.toGeoJSON();
    },

  },

};
</script>

<style scoped>

    #map_647fa6b4730c4f3e973f4d3a0821b5b5 {
        position: relative;
        width: 100.0%;
        height: 100.0%;
        left: 0.0%;
        top: 0.0%;
    }

</style>
