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
            <div v-if="!volunteer">

              <p>&Icirc;ți mulțumim pentru deschiderea ta &icirc;n sprijinirea demersului &ldquo;<strong>Vă ajutăm din Cluj</strong>&rdquo;!</p>
              <p>De aici poți să explorezi tot conținutul platformei.&nbsp;</p>
              <p>Vei observa că apar două declarații pe partea st&acirc;ngă a ecranului. Ele trebuie completate doar de cei care se &icirc;nscriu voluntari &icirc;n programul nostru.</p>
              <p>Deocamdată, tu poți să le vezi și poți vedea și informațiile despre activitatea voluntarilor pe <a href="info.civicsuport.ro"><strong>info.civicsuport.ro</strong>.&nbsp;</a></p>
              <p>Dacă ai decis să te &icirc;nscrii voluntar apasă pe butonul <strong>&Icirc;nregistrează-te ca voluntar</strong> și te vom ruga să completezi cu atenție formularul de &icirc;nscriere și cele 2 declarații.</p>
              <p>C&acirc;nd cele 2 declarații apar &icirc;n cadrane verzi, ești oficial Voluntar Vă ajutăm din Cluj.</p>
              <p>Putem &icirc;ncepe etapele următoare!</p>
            </div>
          </el-card>

        </el-col>

      </el-row>

      <el-dialog
        title="Notificare"
        :visible.sync="centerDialogVisible"
        width="70%"
        center
      >
        <div style="text-align: center">
          <p>{{ name }}, am observat ca esti inregistrat ca voluntar. Te rugam sa completezi formularul de inscriere.</p>

        </div>
        <span slot="footer" class="dialog-footer">

          <el-button type="primary" @click="redirectToFormular">Completeaza Formular </el-button>

        </span>
      </el-dialog>

      <el-dialog
        title="Notificare"
        :visible.sync="centerDialogVisible2"
        width="70%"
        center
      >
        <div style="text-align: center">
          <p>{{ name }}, am observat ca nu ai semnat acordul pentru voluntari. Te rugam sa semnezi acordul pentru voluntari.</p>

        </div>
        <span slot="footer" class="dialog-footer">

          <el-button type="primary" @click="redirectToAcord">Completeaza Acord </el-button>

        </span>
      </el-dialog>
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
      centerDialogVisible: false,
      centerDialogVisible2: false,
    };
  },

  computed: {
    ...mapGetters([
      'name',
      'volunteer',
      'roles',
    ]),

  },
  mounted(){
    if (this.roles.includes('user') && !this.volunteer){
      this.centerDialogVisible = true;
    }

    if (this.roles.includes('user') && this.volunteer){
      if (!this.volunteer.data_acord){
        this.centerDialogVisible2 = true;
      }
    }
  },
  methods: {

    redirectToFormular(){
      this.centerDialogVisible = false;
      this.$router.push({ path: '/voluntari/inregistrare' });
    },
    redirectToAcord(){
      this.centerDialogVisible = false;
      this.$router.push({ path: '/voluntari/inregistrare?semneaza=true' });
    },

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
