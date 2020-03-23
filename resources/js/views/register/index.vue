<template>
  <div v-cloak class="dashboard-editor-container">
    <div class=" clearfix">
      <el-row :gutter="20">
        <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="8">
          <el-card>

            <div slot="header" class="clearfix">
              <h3 style="    margin: 0px;">Formular inregistare voluntari</h3>
            </div>
            <el-form ref="register" :model="form" label-width="120px" label-position="top" :rules="loginRules" auto-complete="on">
              <el-form-item label="Nume Complet" prop="name">
                <el-input v-model="form.name" />
              </el-form-item>

              <el-form-item label="Email" prop="email">
                <el-input v-model="form.email" />
              </el-form-item>

              <el-form-item label="Phone" prop="phone">
                <el-input v-model="form.phone" />
              </el-form-item>

              <el-form-item label="Judet" prop="county">
                <el-select v-model="form.county" filterable placeholder="Selecteaza judetul" @change="getOraseJudet">
                  <el-option v-for="judet in judete" :key="judet.auto" :label="judet.nume" :value="judet.auto" />
                </el-select>
              </el-form-item>

              <el-form-item label="Oras" prop="city">
                <el-select v-model="form.city" filterable placeholder="Selecteaza orasul">
                  <el-option v-for="(oras,index) in orase" :key="oras.nume+'-oras'+index" :label="oras.nume" :value="oras.nume" />
                </el-select>
              </el-form-item>

              <el-form-item label="Adresa Completa" prop="address">
                <el-input v-model="form.address" />
              </el-form-item>

              <el-form-item label="Cartier" prop="neighborhood">
                <el-select v-model="form.neighborhood" placeholder="Selecteaza cartierul">
                  <el-option label="Andrei Mureșanu" value="Andrei Mureșanu" />
                  <el-option label="Bulgaria" value="Bulgaria" />
                  <el-option label="Bună Ziua" value="Bună Ziua" />
                  <el-option label="Centru" value="Centru" />
                  <el-option label="Dâmbul Rotund" value="Dâmbul Rotund" />
                  <el-option label="Gara" value="Gara" />
                  <el-option label="Gheorgheni" value="Gheorgheni" />
                  <el-option label="Grădini Mănăștur" value="Grădini Mănăștur" />
                  <el-option label="Plopilor" value="Plopilor" />
                  <el-option label="Grigorescu" value="Grigorescu" />
                  <el-option label="Gruia" value="Gruia" />
                  <el-option label="Iris" value="Iris" />
                  <el-option label="Între Lacuri" value="Între Lacuri" />
                  <el-option label="Mănăștur" value="Mănăștur" />
                  <el-option label="Mărăști" value="Mărăști" />
                  <el-option label="Someșeni" value="Someșeni" />
                  <el-option label="Zorilor" value="Zorilor" />
                  <el-option label="Sopor" value="Sopor" />
                  <el-option label="Borhanci" value="Borhanci" />
                  <el-option label="Becaș" value="Becaș" />
                  <el-option label="Făget" value="Făget" />
                  <el-option label="Lomb" value="Lomb" />
                  <el-option label="Tineretului" value="Tineretului" />
                  <el-option label="Pata-Rât" value="Pata-Rât" />
                </el-select>
              </el-form-item>

              <el-form-item label="Zona unde doresti sa devii activ" prop="activation_area">
                <el-input v-model="form.activation_area" />
              </el-form-item>

              <el-form-item label="Tip Implicare" prop="involvement_type">
                <el-select v-model="form.involvement_type" placeholder="Tipul de Implicare">
                  <el-option label="Promoter - va promova informațiile și campania, dar nu este implicat direct in activitatea noastra" value="Promoter" />
                  <el-option label="Susținător - ajuta cu sarcini care nu implica posibilitatea contactului cu persoane bolnave" value="Susținător" />
                  <el-option label="Voluntar - ajuta la distribuirea de pachete cu alimente către persoanele bolnave" value="Voluntar" />
                </el-select>
              </el-form-item>

              <el-form-item label="Directie Implicare" prop="involvement_direction">
                <el-select v-model="form.involvement_direction" placeholder="Directie Implicare">
                  <el-option label="Call Center" value="Call Center" />
                  <el-option label="Medicamente" value="Medicamente" />
                  <el-option label="Alimente" value="Alimente" />
                </el-select>
              </el-form-item>

              <el-form-item label="Disponibilitate" prop="availability">
                <el-select v-model="form.availability" placeholder="Selecteaza disponibilitatea">
                  <el-option label="Zilnica" value="Zilnica" />
                  <el-option label="Saptamanala" value="Saptamanala" />
                </el-select>
              </el-form-item>

              <el-form-item :label="form.availability ==='Zilnica' ? 'In ce interval orar puteti ?' : 'Cate ore pe saptamana?'" prop="availability_details">
                <el-input v-model="form.availability_details" />
              </el-form-item>

              <el-form-item label="Detineti autoturism?" prop="has_car">
                <el-select v-model="form.has_car" placeholder="Detineti autoturism?">
                  <el-option label="Da" value="Da" />
                  <el-option label="Nu" value="Nu" />
                </el-select>
              </el-form-item>

              <el-form-item v-if="form.has_car==='Da'" label="Numar Masina" prop="car_plates">
                <el-input v-model="form.car_plates" type="text" />
              </el-form-item>

              <el-form-item label="Observatii">
                <el-input v-model="form.observations" type="textarea" />
              </el-form-item>

              <el-form-item>
                <el-button :loading="loading" type="primary" style="width:100%;" @click.native.prevent="form.id ? update() : handleRegister()">
                  {{ form.id ? "Actualizeaza" : "Inregistrare" }}
                </el-button>
              </el-form-item>

            </el-form>

          </el-card>
        </el-col>

        <el-col :xs="24" :sm="24" :md="14" :lg="14" :xl="8">
          <el-card>
            <h4>Selecteaza pe harta zonele unde doresti sa devii activ</h4>
            <ClujMap ref="clujM" :geojson="form.geojson" />
          </el-card>
        </el-col>

      </el-row>

      <el-dialog
        title="DECLARAȚIE PE PROPRIE RĂSPUNDERE"
        :visible.sync="centerDialogVisible"
        width="80%"
        center
      >

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

        <span slot="footer" class="dialog-footer">

          <el-button style="margin-top: 8px" type="primary" @click="validateAcord">Sunt de acord si semnez</el-button>
          <el-button style="margin-top: 8px" @click="centerDialogVisible = false">Cancel</el-button>
        </span>
      </el-dialog>

    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { validEmail } from '@/utils/validate';
import Resource from '@/api/resource';
import ClujMap from './ClujMap';
const volunteersResource = new Resource('volunteers');
import axios from 'axios';

export default {
  name: 'DashboardEditor',
  components: { ClujMap },
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    return {
      judete: [],
      orase: [],
      loading: false,
      centerDialogVisible: false,
      loginRules: {
        email: [{ required: true, trigger: 'blur', message: 'Adresa de email nu este corecta', validator: validateEmail }],
        name: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        phone: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        city: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        address: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        neighborhood: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        activation_area: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        involvement_type: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        involvement_direction: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        availability: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        availability_details: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        car_plates: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],

      },
      form: {
        acord_semnat: false,
        name: '',
        email: '',
        phone: '',
        county: 'CJ',
        city: '',
        address: '',
        neighborhood: '',
        activation_area: '',
        involvement_type: '',
        involvement_direction: '',
        availability: '',
        availability_details: '',
        observations: '',
        geojson: '',
        ci: '',
        cnp: '',
        loc_domiciliu: '',
        str_domiciliu: '',
        nr_domiciliu: '',
        ap_domiciliu: '',
        has_car: 'Nu',
        car_plates: '',
      },
    };
  },
  computed: {
    ...mapGetters([
      'name',
      'email',
      'user_id',
      'roles',
    ]),
  },
  watch: {
    '$route.query.semneaza': (acord) => {
      this.centerDialogVisible = true;
    },
  },
  mounted(){
    this.get();

    axios.get('https://roloca.coldfuse.io/judete').then(resp => {
      this.judete = resp.data;
    });

    if (this.$route.query['semneaza']){
      this.centerDialogVisible = true;
    }

    this.getOraseJudet();
  },

  methods: {
    handleRegister() {
      this.$refs.register.validate(valid => {
        if (valid) {
          this.loading = true;
          this.centerDialogVisible = true;
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    validateAcord(){
      console.log('validate click');

      this.$validator.validateAll().then(res => {
        if (res){
          this.form.acord_semnat = true;
          if (this.form.id){
            this.update();
          } else {
            this.registerVolunteer();
          }
        } else {
          this.$message({
            message: 'Trebuie sa completezi toate datele acordului',
            type: 'error',
            duration: 5 * 1000,
          });
        }
      });
    },

    registerVolunteer(){
      this.form.geojson = this.$refs.clujM.getGeoJSON();
      volunteersResource
        .store(this.form)
        .then(response => {
          this.$message({
            message: 'Ai fost inregistrat ca voluntar',
            type: 'success',
            duration: 5 * 1000,
          });
          this.centerDialogVisible = true;
          this.loading = false;
          this.$router.push('/dashboard');
          this.$store.dispatch('user/addVolunteer', response.volunteer);
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    update(){
      this.form.geojson = this.$refs.clujM.getGeoJSON();

      this.$refs.register.validate(valid => {
        if (valid) {
          this.loading = true;

          volunteersResource
            .update(this.form.id, this.form)
            .then(response => {
              this.$message({
                message: 'Datele au fost actualizate',
                type: 'success',
                duration: 5 * 1000,
              });
              this.centerDialogVisible = true;
              this.loading = false;
              this.$store.dispatch('user/addVolunteer', response.volunteer);
              this.$router.push('/dashboard');
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.loading = false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    get(){
      volunteersResource
        .get(this.user_id)
        .then(response => {
          this.loading = false;

          if (response.volunteer){
            this.form = response.volunteer;
            if (!this.form.county){
              this.form.county = 'CJ';
              this.form.city = 'Cluj-Napoca';
            }
          } else {
            this.form.name = this.name;
            this.form.email = this.email;
          }
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    getOraseJudet(){
      axios.get('https://roloca.coldfuse.io/orase/' + this.form.county).then(resp => {
        this.orase = resp.data;
      });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" >
  [v-cloak] { display:none; }

  .special-form-input-text {

    input {

      border-top: 0!important;
      border-left: 0!important;
      border-right: 0!important;
      border-radius: 0!important;
      border-color: black!important;
      border-bottom-style: dashed!important;
      font-weight: bold;
      color: #000;
    }

    border-radius: 0!important;
    margin-bottom: 10px;

  }

  @media screen and (max-width: 767px) {

    .special-form-input-text {

      width: 100%!important;
    }

  }

  @media screen and (min-width: 768px) {
    .special-form-input-text {

      width: 160px!important;
    }
  }

  .special-form-input-text-no-width {

    input {

      border-top: 0!important;
      border-left: 0!important;
      border-right: 0!important;
      border-radius: 0!important;
      border-color: black!important;
      border-bottom-style: dashed!important;
      font-weight: bold;
      color: #000;
    }

    border-radius: 0!important;
    margin-bottom: 10px;

  }

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

    .el-select {

      width: 100%!important;
    }
  }

  .el-form-item {

    label{

      padding: 0!important;
    }
  }

</style>
