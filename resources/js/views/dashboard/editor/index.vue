<template>
  <div class="dashboard-editor-container">
    <div class=" clearfix">
      <el-row :gutter="20">
        <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="6">
          <user-card ref="userCard" />
          <!--<user-bio />-->
        </el-col>
        <el-col :xs="24" :sm="24" :md="15" :lg="15" :xl="18">
          <el-card>

            <h4><strong>Bine ai venit {{ name }}!</strong></h4>
            <p><span style="font-weight: 400;">Urmatoarele cateva saptamani, se anunta a fi grele pentru comunitatea noastra. Stim ca vom fi afectati de COVID 19, dar acesta nu este motiv de panica.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Este in schimb un motiv de mobilizare si organizare. Impreuna incercam sa formam grupuri de voluntari care sa ajute comunitatea noastra sa treaca peste aceasta criza.&nbsp;</span></p>
            <p><span style="font-weight: 400;"><strong>Am identificat pana acum mai multe feluri in care putem face asta:</strong>&nbsp;</span></p>
            <p>&nbsp;</p>
            <ul>
              <li style="font-weight: 400;"><span style="font-weight: 400;">Sa organizam o retea de distribuire cat mai rapida a informatiilor relevante, verificate si urgente pe retelele de socializare si direct de la om la om.</span></li>
            </ul>
            <p>&nbsp;</p>
            <ul>
              <li style="font-weight: 400;"><span style="font-weight: 400;">Sa contribuim responsabil la educarea populatie pe teme care tin de epidemia de COVID 19.&nbsp;</span></li>
            </ul>
            <p>&nbsp;</p>
            <ul>
              <li style="font-weight: 400;"><span style="font-weight: 400;">Sa distribuim produse alimentare intr-un mod sigur, celor care sunt izolati la domiciliu.&nbsp;</span></li>
            </ul>
            <p><br><span style="font-weight: 400;">Daca vrei sa te alaturi acestei initiative, te rugam sa completezi formularul de pe site.&nbsp;</span></p>
            <p>&nbsp;</p>
            <p><strong>Nota:&nbsp;</strong></p>
            <p><span style="font-weight: 400;">Ne confruntam cu o criza reala, oameni ca noi sunt afectati direct si au de suferit in fiecare zi. Suntem inca la inceputul acestei epidemii, si vor urma vremuri dificile.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Maturitatea si seriozitatea voluntarilor este esentiala pentru a avea o contributie pozitiva. Te rugam sa te gandesti foarte bine si sa-ti asumi sarcinile care sti ca le poti face.&nbsp;</span></p>
            <p>&nbsp;</p>
            <p><strong>Nu este un joc!</strong></p>
          </el-card>

        </el-col>

      </el-row>
    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex';

import UserCard from './UserCard';

export default {
  name: 'DashboardEditor',
  components: { UserCard },
  data() {
    return {
      emptyGif: 'https://media.giphy.com/media/Ai8iZqHx2i0fK/giphy.gif',
    };
  },
  computed: {
    ...mapGetters([
      'name',
      'roles',
    ]),
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  .emptyGif {
    display: block;
    width: 45%;
    margin: 0 auto;
  }

  .dashboard-editor-container {
    background-color: #e3e3e3;
    min-height: 100vh;
    padding: 50px 60px 0px;
    .pan-info-roles {
      font-size: 12px;
      font-weight: 700;
      color: #333;
      display: block;
    }
    .info-container {
      position: relative;
      margin-left: 190px;
      height: 150px;
      line-height: 200px;
      .display_name {
        font-size: 48px;
        line-height: 48px;
        color: #212121;
        position: absolute;
        top: 25px;
      }
    }
  }
</style>
