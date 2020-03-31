<template>
  <el-card v-if="name" v-cloak>
    <div v-cloak class="user-profile">

      <div v-if="avatar" class="user-avatar box-center">
        <!--<pan-thumb :image="user.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />-->

        <el-image

          style="width: 100px; height: 100px;border-radius: 4px;"
          :src="avatar"
        />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          {{ name }}
        </div>
        <div class="user-role text-center text-muted" style="margin-bottom: 15px">
          Zona Cluj
        </div>
        <div class="user-name text-center">
          <el-tag
            v-if="!volunteer"
            type="danger"
            effect="dark"
          >Neinregistrat</el-tag>
        </div>

        <el-tag
          v-if="volunteer"
          type="success"
          effect="dark"
        >Inregistrat</el-tag>
      </div>

      <div class="declaratii-wrapper">
        <el-button :icon="volunteer && volunteer.ip_acord ? 'el-icon-success' : 'el-icon-warning'" :type="volunteer && volunteer.ip_acord ? 'success' : 'warning'" @click="centerDialogVisible=true">{{ volunteer && volunteer.ip_acord ? 'Vezi' : 'Semneaza' }} declaratie pe proprie raspundere </el-button>
        <el-button :icon="volunteer && volunteer.ip_acord_voluntariat ? 'el-icon-success' : 'el-icon-warning'" :type="volunteer && volunteer.ip_acord_voluntariat ? 'success' : 'warning'" @click="centerDialogVisibleVoluntariat=true"> {{ volunteer && volunteer.ip_acord_voluntariat ? 'Vezi' : 'Semneaza' }} Declaratie Voluntariat </el-button>
      </div>

      <div class="box-social">
        <el-table :data="volunteerList" :show-header="false">
          <el-table-column prop="name" label="Name" />
          <el-table-column prop="info" label="Info" align="left" />

        </el-table>
      </div>

      <div class="user-follow">
        <router-link to="/voluntari/inregistrare">
          <el-button type="primary" style="width: 100%;">
            {{ volunteer ? "Actualizare date" : "Inregistrare voluntar" }}
          </el-button>
        </router-link>
        <template>
          <el-button style="margin-top: 10px; width: 100%;" :icon="'el-icon-warning'" :type="'danger'" @click="deleteProfile">Sterge profilul</el-button>
        </template>
      </div>
    </div>

    <el-dialog
      title="DECLARAȚIE PE PROPRIE RĂSPUNDERE"
      :visible.sync="centerDialogVisible"
      width="80%"
      center
    >
      <form class="columns column is-multiline is-12" data-vv-scope="acord-isu" @submit.prevent="validateAcord('acord-isu')">
        <el-row>

          <el-col>
            <p style="text-align: center;"><strong>ACORD DE PRELUCRARE A DATELOR CU CARACTER PERSONAL</strong></p>
            <p style="text-align: center;">&nbsp;</p>
            <p>Subsemnatul  <el-input
              v-model="form.name"
              v-validate="'required'"
              name="form.name"
              class="special-form-input-text "
              placeholder="Numele complet"
            />, identificat cu C.I. seria  nr. <el-input
              v-model="form.ci"
              v-validate="'required'"
              name="form.ci"
              class="special-form-input-text "
              placeholder="Ex: CJ 000000"
            />, CNP <el-input
              v-model="form.cnp"
              v-validate="'required'"
              name="form.cnp"
              class="special-form-input-text "
              placeholder="Ex: 1890909090900"
            />, cu domiciliul in loc <el-input
              v-model="form.loc_domiciliu"
              v-validate="'required'"
              name="form.loc_domiciliu"
              class="special-form-input-text "
              placeholder="Ex: Cluj-Napoca, Cluj"
            />, str <el-input
              v-model="form.str_domiciliu"
              v-validate="'required'"
              name="form.str_domiciliu"
              class="special-form-input-text "
              placeholder="Ex: Fierului"
            /> nr. <el-input
              v-model="form.nr_domiciliu"
              v-validate="'required'"
              name="form.nr_domiciliu"
              class="special-form-input-text-no-width"
              style="width: 100px"
              placeholder="Ex: 22/A"
            />, ap. <el-input
              v-model="form.ap_domiciliu"
              v-validate="'required'"
              name="form.ap_domiciliu"
              class="special-form-input-text-no-width"
              style="width: 80px"
              placeholder="Ex: 9"
            />, nr. tel. <el-input
              v-model="form.phone"
              v-validate="'required'"
              name="form.phone"
              class="special-form-input-text "
              placeholder="Ex: 075890375"
            />, email <el-input
              v-model="form.email"
              v-validate="'required|email'"
              class="special-form-input-text-no-width"
              style="width: 250px"
              name="form.email"
              placeholder="Ex: ioan.pop@example.com"
            />, <strong>declar că particip &icirc;n mod voluntar la activitățile de sprijinire a persoanelor care se află &icirc;n monitorizarea autorităților locale și a cadrelor medicale, &icirc;n contextul aplicării de către autorități a măsurilor de prevenire a infectării populației cu noul coronavirus(COVID-19</strong><strong>)</strong>.</p>
            <p>Declar prin prezenta că sunt conștient de natura activității care urmează să o desfășor și &icirc;mi asum eventualele consecințe &icirc;n cazul &icirc;n care voi suferi un accident sau voi fi vătămat, din cauze av&acirc;nd &icirc;n mod direct sau indirect legătură cu natura activității.&nbsp;</p>
            <p>Mă angajez să respect regulile de lucru pe care cadrele medicale si autoritațile le stabilesc și regulile de siguranță comunicate de către acestea.</p>
            <p>Autorizez și &icirc;mi dau consimțăm&acirc;ntul expres de a fi transportat la spital și de a mi se asigura asistența medicală &icirc;n cazul &icirc;n care acestea sunt necesare.</p>
            <p>Acord dreptul de a fi &icirc;nregistrat foto, audio și video pe perioada desfășurării activitaților și nu voi avea ulterior nici o pretenție materială sau de altă natură. Cunosc&acirc;nd că falsul &icirc;n declarații este pedepsit de legea penală, declar pe propria răspundere următoarele: sunt apt pentru participarea la aceste activitați de sprijin a persoanelor afectate de noul coronavirus; nu sufăr de afecţiuni grave sau contagioase care ar putea infuenţa activitatea desfașurată; voi urma toate instrucțiunile medicale si organizatorice comunicate de autorități.</p>
            <p>Declar pe propria răspundere că am luat cunoștința de prevederile legale referitoare la protecția datelor cu caracter personal si <strong>consimt să păstrez confidențialitatea datelor cu caracter personal </strong>a căror prelucrare o efectuez și a oricăror informații și date de care iau cunoștinta prin natura activității desfășurate, inclusiv după incetarea activității. Cunosc faptul ca &icirc;ncălcarea normelor legale privind protecția datelor pe care mi-am asumat-o prin prezenta, atrage răspunderea civilă si penală.&nbsp;</p>
            <p><strong>Declar că am fost informat cu privire la procesarea datelor cu caracter personal de către autoritați şi prin semnarea acestei declarații imi exprim consimţăm&acirc;ntul &icirc;n vederea prelucrării acestora, in scopurile pe care autoritățile le consideră necesare &icirc;n vederea desfășurării activitații pentru care m-am oferit voluntar.&nbsp;</strong></p>
            <p>AM SEMNAT PREZENTUL DOCUMENT DUPĂ CE L-AM CITIT CU ATENȚIE ȘI AM &Icirc;NȚELES PE DEPLIN IMPLICAȚIILE REZULTATE DIN SEMNAREA LUI.</p>
            <p><strong>Denumirea organizatiei din care face parte voluntarul:</strong></p>
            <p>Inițiativa Civică &ldquo;Vă ajutăm din Cluj&rdquo;, fondată pe baza protocolului de colaborare &icirc;ntre organizațiile Asociația Voci pentru Democrație și Justiție (VeDem Just), Asociația Civic Support, Asociația Clujul Sustenabil.</p>
            <p>Data: </p>
            <p><strong>{{ new Date().toLocaleDateString() }}</strong></p>
            <p>Nume și prenume</p>
            <p><strong>{{ form.name }}</strong></p>
          </el-col>
        </el-row>

      </form>

      <span slot="footer" class="dialog-footer">

        <el-button style="margin-top: 8px" type="primary" @click="validateAcord('acord-isu')">Sunt de acord si semnez</el-button>
        <el-button style="margin-top: 8px" @click="centerDialogVisible = false">Cancel</el-button>
      </span>
    </el-dialog>

    <el-dialog
      title="DECLARAȚIE DE VOLUNTARIAT"
      :visible.sync="centerDialogVisibleVoluntariat"
      width="80%"
      center
    >
      <form class="columns column is-multiline is-12" data-vv-scope="acord-voluntariat" @submit.prevent="validateAcord('acord-voluntariat')">
        <el-row>

          <el-col>
            <p style="text-align: center;">în acțiunile mișcării civice <strong>„Vă ajutăm din Cluj” </strong> de susținere și ajutorare a locuitorilor din mun. Cluj-Napoca pentru a face față răspândirii și infectării cu virusul Covid-19
            </p>
            <p style="text-align: center;">&nbsp;</p>
            <p>Subsemnatul  <el-input
              v-model="form.name"
              v-validate="'required'"
              name="form.name"
              class="special-form-input-text "
              placeholder="Numele complet"
            />, identificat cu C.I. seria  nr. <el-input
              v-model="form.ci"
              v-validate="'required'"
              name="form.ci"
              class="special-form-input-text "
              placeholder="Ex: CJ 000000"
            />, CNP <el-input
              v-model="form.cnp"
              v-validate="'required'"
              name="form.cnp"
              class="special-form-input-text "
              placeholder="Ex: 1890909090900"
            />, cu domiciliul in loc <el-input
              v-model="form.loc_domiciliu"
              v-validate="'required'"
              name="form.loc_domiciliu"
              class="special-form-input-text "
              placeholder="Ex: Cluj-Napoca, Cluj"
            />, str <el-input
              v-model="form.str_domiciliu"
              v-validate="'required'"
              name="form.str_domiciliu"
              class="special-form-input-text "
              placeholder="Ex: Fierului"
            /> nr. <el-input
              v-model="form.nr_domiciliu"
              v-validate="'required'"
              name="form.nr_domiciliu"
              class="special-form-input-text-no-width"
              style="width: 100px"
              placeholder="Ex: 22/A"
            />, ap. <el-input
              v-model="form.ap_domiciliu"
              v-validate="'required'"
              name="form.ap_domiciliu"
              class="special-form-input-text-no-width"
              style="width: 80px"
              placeholder="Ex: 9"
            />, nr. tel. <el-input
              v-model="form.phone"
              v-validate="'required'"
              name="form.phone"
              class="special-form-input-text "
              placeholder="Ex: 075890375"
            />, email <el-input
              v-model="form.email"
              v-validate="'required|email'"
              class="special-form-input-text-no-width"
              style="width: 250px"
              name="form.email"
              placeholder="Ex: ioan.pop@example.com"
            />. </p>
            <p><strong>declar pe proprie răspundere următoarele:</strong></p>
            <ol>
              <li>am decis de bună-voie să mă implic &icirc;n mișcarea civică <strong>&bdquo;Vă ajutăm din Cluj&rdquo;</strong>;</li>
              <li>sunt de acord să mă implic voluntar &icirc;n aceste activități, fără a pretinde vreo remunerare sau recompensare;</li>
              <li>accept că scopul implicării mele este unul eminamente civic. Ca urmare, nu voi urmări niciun scop politic sau economic;</li>
              <li>mă oblig să mă informez &icirc;n mod constant cu privire la activitățile mișcării civice de pe grupul de facebook special creat;</li>
              <li>mă oblig să &icirc;ndeplinesc atribuțiile pe care mi le asum și, &icirc;n caz de imposibilitate, să &icirc;nștiințez imediat inițiatorii acestei mișcări;</li>
              <li>nu voi folosi &icirc;n interes privat informațiile conțin&acirc;nd date personale ale celor cu care intru &icirc;n contact și nu voi dezvălui publicului aceste informații;</li>
              <li>sunt de acord ca datele mele de contact să fie folosite exclusiv pentru buna desfășurare a activităților din mișcarea civică menționată.</li>
            </ol>
            <p>Data: </p>
            <p><strong>{{ new Date().toLocaleDateString() }}</strong></p>
            <p>Nume și prenume</p>
            <p><strong>{{ form.name }}</strong></p>
          </el-col>
        </el-row>

      </form>

      <span slot="footer" class="dialog-footer">

        <el-button style="margin-top: 8px" type="primary" @click="validateAcord('acord-voluntariat')">Sunt de acord si semnez</el-button>
        <el-button style="margin-top: 8px" @click="centerDialogVisibleVoluntariat = false">Cancel</el-button>
      </span>
    </el-dialog>

  </el-card>
</template>

<script>

import { mapGetters } from 'vuex';

import checkRole from '@/utils/role';
import Resource from '@/api/resource';
import UserResource from '@/api/user';
const volunteersResource = new Resource('volunteers');
const userResource = new UserResource();
export default {
  components: { },

  data() {
    return {
      volunteerList: [],
      centerDialogVisible: false,
      centerDialogVisibleVoluntariat: false,
      form: {
        acord: '',
        name: '',
        email: '',
        phone: '',
        county: 'CJ',
        city: '',
        address: '',
        ci: '',
        cnp: '',
        loc_domiciliu: '',
        str_domiciliu: '',
        nr_domiciliu: '',
        ap_domiciliu: '',

      },
    };
  },
  computed: {
    ...mapGetters([
      'roles',
      'name',
      'email',
      'avatar',
      'volunteer',
    ]),
  },

  watch: {
    // will fire on route changes
    // '$route.params.id': function(val, oldVal){ // Same
    '$route.query': function(val, oldVal){
      console.log(this.$route.params.id);
      this.get();
    },
  },
  mounted() {
    // this.$nextTick(function() {
    //   // some init codes for chart implementation
    //   this.get();
    // });

    this.mapVolunteersData();
  },

  methods: {
    checkRole,
    getRole() {
      const roles = this.user.roles.map(value => this.$options.filters.uppercaseFirst(value));
      return roles.join(' | ');
    },
    facebook(){
      // window.open('/redirect')
      window.location.href = '/redirect';
    },

    get(){
      volunteersResource
        .get(this.user_id)
        .then(response => {
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    mapVolunteersData(){
      if (this.volunteer){
        this.form = this.volunteer;
        const mapFields = {
          name: 'Nume',
          email: 'Email',
          phone: 'Telefon',
          city: 'Oras',
          address: 'Adresa',

          involvement_direction: 'Tip implicare',

        };

        this.volunteerList = [];

        Object.entries(this.volunteer).forEach(entry => {
          const key = entry[0];
          const value = entry[1];
          if (mapFields[key]){
            this.volunteerList.push({
              name: mapFields[key],
              info: value,

            });
          }
        });
      } else {
        this.form.name = this.name;
        this.form.email = this.email;
      }
    },

    validateAcord(scope){
      console.log('validate click');

      this.$validator.validateAll(scope).then(res => {
        if (res){
          this.form.acord = scope;
          this.addOrUpdateAcord();
        } else {
          this.$message({
            message: 'Trebuie sa completezi toate datele acordului',
            type: 'error',
            duration: 5 * 1000,
          });
        }
      });
    },
    addOrUpdateAcord(){
      userResource.addOrUpdateAcord(this.form).then(response => {
        this.$store.dispatch('user/addVolunteer', response.volunteer);
        this.mapVolunteersData();
        this.$message({
          message: 'Acordul a fost semnat',
          type: 'success',
          duration: 5 * 1000,
        });
        this.centerDialogVisible = false;
        this.centerDialogVisibleVoluntariat = false;
      });
    },
    deleteProfile(){
      this.$confirm('Profilul și toate datele introduse vor fi șterse.', 'Atentie!!!', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        beforeClose: (action, instance, done) => {
          if (action === 'confirm') {
            volunteersResource.destroy(this.volunteer.id).then(response => {
              this.logout();
            });
            done();
          } else {
            done();
          }
        },
      }).then(() => {
        this.$message({
          type: 'success',
          message: 'Delete completed',
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
    async logout() {
      await this.$store.dispatch('user/logout');
      this.$router.push(`/login?redirect=${this.$route.fullPath}`);
    },
  },
};
</script>

<style lang="scss" scoped>

  .declaratii-wrapper {

    text-align: center;
    margin-top: 10px;
    button {
      margin-top: 10px;
    }
  }

.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .user-follow {
    padding-top: 20px;
  }

  .loginBtn {
    box-sizing: border-box;
    position: relative;
    /* width: 13em;  - apply for fixed size */
    margin: 0.2em;
    padding: 0 15px 0 46px;
    border: none;
    text-align: left;
    line-height: 34px;
    white-space: nowrap;
    border-radius: 0.2em;
    font-size: 16px;
    color: #FFF;
  }
  .loginBtn:before {
    content: "";
    box-sizing: border-box;
    position: absolute;
    top: 0;
    left: 0;
    width: 34px;
    height: 100%;
  }
  .loginBtn:focus {
    outline: none;
  }
  .loginBtn:active {
    box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
  }

  /* Facebook */
  .loginBtn--facebook {
    background-color: #4C69BA;
    background-image: linear-gradient(#4C69BA, #3B55A0);
    /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
    text-shadow: 0 -1px 0 #354C8C;
  }
  .loginBtn--facebook:before {
    border-right: #364e92 1px solid;
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
  }
  .loginBtn--facebook:hover,
  .loginBtn--facebook:focus {
    background-color: #5B7BD5;
    background-image: linear-gradient(#5B7BD5, #4864B1);
  }
}
</style>
