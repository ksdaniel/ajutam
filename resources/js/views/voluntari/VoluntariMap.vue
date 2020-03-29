<template>
  <div style="height: 750px">

    <div id="mapShow" />

  </div>

</template>

<script>

import { getMapVolunteers } from '@/api/search';

export default {
  name: 'VoluntariMap',
  data(){
    return {
      drawnItems: false,
      mapObj: false,
    };
  },
  mounted(){
    this.mapObj = L.map(
      'mapShow',
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

    this.get();
  },
  methods: {
    get(){
      getMapVolunteers('').then(res => {
        console.log(res);

        res.volunteers.forEach(item => {
          if (item.geojson){
            if (item.geojson.features.length > 0){
              item.geojson.features.map(f => {
                f.properties = {
                  name: item.name,
                  email: item.email,
                  phone: item.phone,
                };
                return f;
              });

              var geojson = L.geoJSON(item.geojson).bindPopup(function(layer) {
                const popup = '<span>Voluntar: </span><strong>' + layer.feature.properties.name + '</strong><br>'

                 ;

                return popup;
              }).addTo(this.mapObj);
            }
          }
        });
      });
    },
  },

};
</script>

<style scoped>
    #mapShow {
        position: relative;
        width: 100.0%;
        height: 100.0%;
        left: 0.0%;
        top: 0.0%;
    }
</style>
