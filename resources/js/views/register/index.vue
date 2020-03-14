<template>
  <div class="dashboard-editor-container">
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

              <el-form-item label="Oras" prop="city">
                <el-select v-model="form.city" placeholder="Selecteaza orasul">
                  <el-option label="Cluj-Napoca" value="cluj-napoca" />
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

              <el-form-item label="Disponibilitate" prop="availability">
                <el-select v-model="form.availability" placeholder="Selecteaza disponibilitatea">
                  <el-option label="Zilnica" value="Zilnica" />
                  <el-option label="Saptamanala" value="Saptamanala" />
                </el-select>
              </el-form-item>

              <el-form-item :label="form.availability ==='Zilnica' ? 'In ce interval orar puteti ?' : 'Cate ore pe saptamana?'" prop="availability_details">
                <el-input v-model="form.availability_details" />
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
          <el-card />
          <iframe src="https://coronaclujstorage.z6.web.core.windows.net/" style="width: 100%;    height: 500px;" />
        </el-col>

      </el-row>

      <el-dialog
        title="Acord"
        :visible.sync="centerDialogVisible"
        width="60%"
        center
      >

        <p style="text-align: center;"><strong>DECLARAȚIE DE VOLUNTARIAT</strong></p>
        <p><span style="font-weight: 400;">&icirc;n acțiunile mișcării civice</span><strong> &bdquo;Vă ajutăm din Cluj&rdquo;</strong><span style="font-weight: 400;"> de susținere și ajutorare a locuitorilor din mun. Cluj-Napoca pentru a face față răsp&acirc;ndirii și infectării cu virusul Covid-19</span></p>
        <p>&nbsp;</p>
        <p><span style="font-weight: 400;">Subsemnatul <strong>{{ form.name }}</strong> cu domiciliul in Cluj-Napoca, {{ form.address }}, jud. Cluj, telefon <strong>{{ form.phone }}</strong>, email <strong>{{ form.name }}</strong></span></p>
        <p><span style="font-weight: 400;">declar pe proprie răspundere următoarele:</span></p>
        <ol>
          <li style="font-weight: 400;"><span style="font-weight: 400;">am decis de bună-voie să mă implic &icirc;n mișcarea civică </span><strong>&bdquo;Vă ajutăm din Cluj&rdquo;</strong><span style="font-weight: 400;">;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">sunt de acord să mă implic voluntar &icirc;n aceste activități, fără a pretinde vreo remunerare sau recompensare;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">accept că scopul implicării mele este unul eminamente civic. Ca urmare, nu voi urmări niciun scop politic sau economic;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">mă oblig să mă informez &icirc;n mod constant cu privire la activitățile mișcării civice de pe grupul de facebook special creat;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">mă oblig să &icirc;ndeplinesc atribuțiile pe care mi le asum și, &icirc;n caz de imposibilitate, să &icirc;nștiințez imediat inițiatorii acestei mișcări;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">nu voi folosi &icirc;n interes privat informațiile conțin&acirc;nd date personale ale celor cu care intru &icirc;n contact și nu voi dezvălui publicului aceste informații;</span></li>
          <li style="font-weight: 400;"><span style="font-weight: 400;">sunt de acord ca datele mele de contact să fie folosite exclusiv pentru buna desfășurare a activităților din mișcarea civică menționată.</span></li>
        </ol>

        <span slot="footer" class="dialog-footer">
          <el-button @click="centerDialogVisible = false">Cancel</el-button>
          <el-button type="primary" @click="validateAcord">Sunt de acord</el-button>
        </span>
      </el-dialog>

    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { validEmail } from '@/utils/validate';
import Resource from '@/api/resource';
const volunteersResource = new Resource('volunteers');

export default {
  name: 'DashboardEditor',
  components: { },
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    return {
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
        availability: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],
        availability_details: [{ required: true, trigger: 'change', message: 'Campul este obligatoriu' }],

      },
      form: {
        name: '',
        email: '',
        phone: '',
        city: '',
        address: '',
        neighborhood: '',
        activation_area: '',
        involvement_type: '',
        availability: '',
        availability_details: '',
        observations: '',
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
  mounted(){
    this.get();
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
          this.$router.push('/');
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    update(){
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
              this.$router.push('/');
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
