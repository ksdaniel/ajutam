<template xmlns:img="http://www.w3.org/1999/html">
  <div class="add-wrapper">

    <el-form ref="addForm" :model="formData">
      <el-row :gutter="20">

        <el-col :xs="24" :md="12" :span="6"><el-card>
          <div slot="header" class="clearfix">
            <h3>Date identificare beneficiar</h3>
          </div>

          <div>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Nume"
                prop="beneficiar.first_name"
                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-input v-model="formData.beneficiar.first_name" />

              </el-form-item>
            </el-col>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Prenume"
                prop="beneficiar.last_name"
                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-input v-model="formData.beneficiar.last_name" />

              </el-form-item>
            </el-col>
          </div>

          <div>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Judet"
                prop="beneficiar.county"
                :rules="{
                  required: true,
                  message: 'Este necesara selectarea judetului',
                  trigger: 'blur'
                }"
              >
                <el-select v-model="formData.beneficiar.county" style="    width: 100%;" filterable placeholder="Selecteaza judetul" @change="getOraseJudet">
                  <el-option v-for="judet in judete" :key="judet.auto" :label="judet.nume" :value="judet.auto" />
                </el-select>

              </el-form-item>
            </el-col>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Oras"
                prop="beneficiar.city"
                :rules="{
                  required: true,
                  message: 'Este necesar orasului',
                  trigger: 'blur'
                }"
              >
                <el-select v-model="formData.beneficiar.city" style="    width: 100%;" filterable placeholder="Selecteaza orasul">
                  <el-option v-for="(oras,index) in orase" :key="oras.nume+'-oras'+index" :label="oras.nume" :value="oras.nume" />
                </el-select>
              </el-form-item>
            </el-col>
          </div>

          <div>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Cartier"
                prop="beneficiar.neighborhood"
                :rules="{
                  required: true,
                  message: 'Este necesara selectarea cartierului',
                  trigger: 'blur'
                }"
              >
                <el-select v-model="formData.beneficiar.neighborhood" style="width: 100%" placeholder="Selecteaza cartierul">
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
                  <el-option label="Alt cartier" value="altul" />
                </el-select>

              </el-form-item>
            </el-col>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Adresa"
                prop="beneficiar.address"
                :rules="{
                  required: true,
                  message: 'Este necesar sa introduceti adresa',
                  trigger: 'blur'
                }"
              >
                <el-input v-model="formData.beneficiar.address" />

              </el-form-item>
            </el-col>
          </div>

          <div>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Numar telefon"
                prop="beneficiar.phone"
                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-input v-model="formData.beneficiar.phone" />

              </el-form-item>
            </el-col>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Observatii beneficiar"
                prop="beneficiar.observations"
              >

                <el-input v-model="formData.beneficiar.observations" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />

              </el-form-item>
            </el-col>
          </div>

          <h3>Stabilire urgenta solicitare</h3>

          <div class="clearfix">

            <el-form-item
              v-for="(intrebare, index) in intrebari.intrebariStabilireUrgenta"
              :key="intrebare.key"
              :label="intrebare.label"
              :prop="'beneficiar.additional_responses.' + intrebare.key"
              :rules="intrebare.validationRules"
            >
              <el-input v-if="intrebare.type==='text'" v-model="formData.beneficiar.additional_responses[intrebare.key]" />
              <el-input v-if="intrebare.type==='texarea'" v-model="formData.beneficiar.additional_responses[intrebare.key]" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />

            </el-form-item>

          </div>

        </el-card></el-col>

        <el-col :xs="24" :md="12" :span="6"><el-card>
          <div slot="header" class="clearfix">
            <h3>Procesare solicitare</h3>

          </div>

          <el-form-item
            label="Tip solicitare"
            prop="solicitation.categories"
            :rules="{
              required: true,
              message: 'Este necesar sa selectati tipul solicitarii',
              trigger: 'blur'
            }"
          >
            <el-select v-model="formData.solicitation.categories" placeholder="Categorie" clearable style="width: 250px" class="filter-item">
              <el-option label="Are Nevoie de Alimente" value="alimente" />
              <el-option label="Are Nevoie de Medicamente" value="medicamente" />

            </el-select>

          </el-form-item>

          <div v-if="formData.solicitation.categories==='medicamente'">

            <el-form-item
              v-for="(intrebare) in intrebari.intrebariMedicamente"
              :key="intrebare.key"
              :label="intrebare.label"
              :prop="'solicitation.additional_responses.' + intrebare.key"
              :rules="intrebare.validationRules"
            >
              <el-input v-if="intrebare.type==='text'" v-model="formData.solicitation.additional_responses[intrebare.key]" />
              <el-input v-if="intrebare.type==='textarea'" v-model="formData.solicitation.additional_responses[intrebare.key]" type="textarea" :autosize="{ minRows: 2, maxRows: 6}" />

            </el-form-item>

          </div>

          <div v-if="formData.solicitation.categories==='alimente'">
            <el-form-item
              label="Tip pachet alimente"
              prop="solicitation.additional_responses.tip_cos"
              :rules="{
                required: true,
                message: 'Este necesar sa selectati tipul de pachet',
                trigger: 'blur'
              }"
            >
              <el-select v-model="formData.solicitation.additional_responses.tip_cos" placeholder="Cos alimente" clearable style="width: 100%" class="filter-item" @change="calculPret">
                <el-option v-for="pachet in pacheteAlimente" :key="pachet.key" :label="pachet.label" :value="pachet.key" />
                <el-option label="Pachet personalizat - max 8 produse" value="personalizat" />
                <el-option label="Nu este nevoie de pachet" value="nada" />
              </el-select>

            </el-form-item>

            <div v-if="formData.solicitation.additional_responses.tip_cos && formData.solicitation.additional_responses.tip_cos!=='personalizat' && formData.solicitation.additional_responses.tip_cos!=='nada'">
              <img style="width: 100%" :src="'/images/'+formData.solicitation.additional_responses.tip_cos+'.png'">

            </div>

            <el-form-item v-if="formData.solicitation.additional_responses.tip_cos==='personalizat'" label="Cos pesonalizat " class="checkbox-list">
              <el-checkbox-group v-model="formData.solicitation.additional_responses.cos_personalizat" :max="8">
                <el-checkbox v-for="produs in produsePachetPersonalizat" :key="produs.key" :label="produs.label" name="cos_personalizat" :value="produs.key" @change="calculPret" />

              </el-checkbox-group>
            </el-form-item>

            <div>

              <el-form-item label="Produse Aditionale" class="checkbox-list">
                <el-checkbox-group v-model="formData.solicitation.additional_responses.produse_aditionale">
                  <el-checkbox v-for="produs in produseAditionale" :key="produs.key" :label="produs.label" name="cos_personalizat" :value="produs.key" @change="calculPret" />

                </el-checkbox-group>
              </el-form-item>

            </div>

            <div class="clearfix">
              <el-form-item
                v-for="(intrebare) in intrebari.intrebariAlimente"
                :key="intrebare.key"
                class="intrebari-label"
                :label="intrebare.label"
                :prop="'solicitation.additional_responses.' + intrebare.key"
                :rules="intrebare.validationRules"
              >
                <el-input v-if="intrebare.type==='text'" v-model="formData.solicitation.additional_responses[intrebare.key]" />
                <el-input v-if="intrebare.type==='textarea'" v-model="formData.solicitation.additional_responses[intrebare.key]" type="textarea" :autosize="{ minRows: 2, maxRows: 6}" />

              </el-form-item>

            </div>

          </div>

          <div>
            <el-col :span="8" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Metoda Plata"
                prop="solicitation.payment_type"
                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-select v-model="formData.solicitation.payment_type" placeholder="Metoda plata" clearable style="width: 100%" class="filter-item">
                  <el-option label="Plata Cash" value="plata_cash" />
                  <el-option label="Plata Online" value="plata_card" />
                </el-select>

              </el-form-item>
            </el-col>

            <el-col :span="8" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Status Plata"
                prop="solicitation.payment_status"
              >

                <el-select v-model="formData.solicitation.payment_status" placeholder="Metoda plata" clearable style="width: 100%" class="filter-item">
                  <el-option label="Achitat" value="Achitat" />
                  <el-option label="Neachitat" value="Neachitat" />
                </el-select>

              </el-form-item>
            </el-col>

            <el-col :span="8" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Pret pachet aproximativ"
                prop="solicitation.payment_value"
              >

                <el-input-number v-model="formData.solicitation.payment_value" :precision="2" :step="5" />

              </el-form-item>
            </el-col>
          </div>

          <div>

            <el-col :span="8" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Urgenta"
                prop="solicitation.emergency"
                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-select v-model="formData.solicitation.emergency" placeholder="Nivel urgenta" clearable style="width: 100%" class="filter-item">
                  <el-option label="Livrare normala" value="normal" />
                  <el-option label="Livrare urgenta" value="urgent" />
                </el-select>

              </el-form-item>
            </el-col>

            <el-col :span="16" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Observatii"
                prop="solicitation.observations"
              >

                <el-input v-model="formData.solicitation.observations" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
              </el-form-item>
            </el-col>

          </div>

          <div>
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                v-role="['admin', 'coordonator']"
                label="Status solicitare"
                prop="solicitation.status"

                :rules="{
                  required: true,
                  message: 'Este necesara completarea',
                  trigger: 'blur'
                }"
              >

                <el-select v-model="formData.solicitation.status" placeholder="Status" clearable style="width: 100%" class="filter-item">
                  <el-option label="Necesita Voluntar" value="necesita_voluntar" />
                  <el-option label="Planificat" value="planificat" />
                  <el-option label="In lucru" value="in_lucru" />
                  <el-option label="In proces de livrare" value="proces_livrare" />
                  <el-option label="Livrat" value="livrat" />
                </el-select>

              </el-form-item>
            </el-col>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">

              <el-form-item
                label="Aloca unui coordonator"
                prop="solicitation.coordonator_id"
              >

                <el-select
                  v-model="formData.solicitation.coordonator_id"
                  v-role="['admin', 'coordonator']"
                  placeholder="Scrie Nume coordonator"
                  clearable
                  filterable
                  remote
                  style="width: 100%"
                  class="filter-item"
                  :remote-method="searchCoordonator"
                  :loading="searchLoading"
                >

                  <el-option
                    v-for="item in coordinators"
                    :key="'coor'+item.id"
                    :label="item.name + ' ( '+item.phone+' )'"
                    :value="item.id"
                  />

                </el-select>

              </el-form-item>

            </el-col>
          </div>

          <div class="clearfix">
            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item

                label="Voluntari"
                prop="solicitation.volunteer_id"
              >

                <el-select

                  v-if="formData.solicitation"
                  v-model="formData.solicitation.volunteer_id"
                  v-role="['admin', 'coordonator']"
                  placeholder="Scrie Nume voluntar"

                  clearable
                  filterable
                  remote
                  style="width: 100%"
                  class="filter-item"

                  :remote-method="searchVoluntar"
                  :loading="searchLoading"
                >

                  <el-option
                    v-for="item in volunteers"
                    :key="'vol'+item.id"
                    :label="item.name + ' ( '+item.phone+' )'"
                    :value="item.id"
                  />

                </el-select>

              </el-form-item>
            </el-col>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Confirmare voluntar"
                prop="solicitation.volunteer_confirmation"
                style="  margin-top: 35px;"
              >
                <el-switch
                  v-model="formData.solicitation.volunteer_confirmation"
                /> <span>{{ formData.solicitation.volunteer_confirmation ? "Voluntar confirmat" : "Voluntar neconfirmat" }}</span>

              </el-form-item>
            </el-col>

          </div>

          <div>
            <el-col :span="8" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Perioada de livrare"
                prop="solicitation.delivery_period"
              >

                <el-select v-model="formData.solicitation.delivery_period" placeholder="Alege perioada de livrare" clearable filterable style="width: 100%" class="filter-item">
                  <el-option label="Cat de repade posibil" value="asap" />
                  <el-option label="24 de ore" value="24h" />
                  <el-option label="48 de ore" value="48h" />
                </el-select>

              </el-form-item>
            </el-col>

            <el-col v-role="['admin', 'coordonator']" :span="16" :xs="24" style="margin-bottom: 5px;">
              <el-form-item
                label="Observatii livrare"
                prop="solicitation.delivery_observation"
              >

                <el-input v-model="formData.solicitation.delivery_observation" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
              </el-form-item>
            </el-col>

          </div>

          <el-col :span="24" :xs="24" style="margin-bottom: 5px">
            <el-button :loading="loading" type="primary" class="pull-right" @click="add">Modifica Solicitare</el-button>
          </el-col>

        </el-card>

        </el-col>

      </el-row>

    </el-form>

  </div>
</template>

<script>
import axios from 'axios';
import intrebari from './data/intrebari';
import { pachete as pacheteAlimente, produsePachetPersonalizat, produseAditionale } from './data/pachete-alimente';
import { mapGetters } from 'vuex';
import Resource from '@/api/resource';
const solicitationsResource = new Resource('solicitations');
import { searchVolunteers } from '@/api/search';
import role from '@/directive/role/index.js';
export default {
  name: 'ModificaSolicitare',
  directives: { role },

  data: () => {
    return {
      searchLoading: false,
      coordinators: [],
      volunteers: [],
      judete: [],
      orase: [],
      loading: false,
      formData: {
        beneficiar: {
          additional_responses: {},
          first_name: '',
          last_name: '',
          city: '',
          county: 'CJ',
          address: '',
          neighborhood: '',
          phone: '',
          observations: '',
          delivery_observation: '',
        },
        solicitation: {
          additional_responses: {
            tip_cos: '',
            cos_personalizat: [],
            produse_aditionale: [],

          },
          payment_value: 0,
          payment_type: 'plata_cash',
          payment_status: 'Neachitat',
          status: 'necesita_voluntar',
          emergency: 'normal',
          categories: '',
          coordonator_id: '',
          delivery_period: '',
        },

      },
      intrebari,
      pacheteAlimente,
      produsePachetPersonalizat,
      produseAditionale,
    };
  },

  computed: {
    ...mapGetters([
      'roles',

    ]),

  },

  mounted(){
    axios.get('https://roloca.coldfuse.io/judete').then(resp => {
      this.judete = resp.data;
    });
    this.getOraseJudet();
    this.getSolicitation();
  },

  methods: {

    getSolicitation(){
      solicitationsResource.get(this.$route.params.id).then(res => {
        if (res.solicitation){
          this.formData = {
            beneficiar: res.solicitation.beneficiary,
            solicitation: res.solicitation,
          };

          if (res.solicitation.volunteer_confirmation){
            this.formData.solicitation.volunteer_confirmation = true;
          }

          if (res.solicitation.volunteer){
            this.volunteers.push(res.solicitation.volunteer);
          }

          if (res.solicitation.coordinator){
            this.coordinators.push(res.solicitation.coordinator);
          }
        } else {
          this.$router.push('/voluntari/lista');
        }
      });
    },
    getOraseJudet(){
      axios.get('https://roloca.coldfuse.io/orase/' + this.formData.beneficiar.county).then(resp => {
        this.orase = resp.data;
      });
    },

    calculPret(){
      const priceArray = [];
      if (this.formData.solicitation.additional_responses.tip_cos){
        if (this.formData.solicitation.additional_responses.tip_cos !== 'personalizat'){
          const cos = this.pacheteAlimente.find(i => i.key === this.formData.solicitation.additional_responses.tip_cos);

          if (cos){
            priceArray.push(parseFloat(cos.price));
          }
        } else {
          this.formData.solicitation.additional_responses.cos_personalizat.forEach(res => {
            const produs = this.produsePachetPersonalizat.find(r => r.label === res);
            if (produs){
              priceArray.push(parseFloat(produs.price));
            }
          });
        }
      }

      this.formData.solicitation.additional_responses.produse_aditionale.forEach(res => {
        const produs = this.produseAditionale.find(r => r.label === res);
        if (produs){
          priceArray.push(parseFloat(produs.price));
        }
      });

      this.formData.solicitation.payment_value = priceArray.reduce((a, b) => a + b, 0).toFixed(2);
    },
    add(){
      this.loading = true;

      this.$refs['addForm'].validate((valid) => {
        if (valid) {
          solicitationsResource
            .update(this.formData.solicitation.id, this.formData)
            .then(response => {
              this.loading = false;

              this.$message({
                type: 'success',
                message: 'Solicitare a fost modificata',
              });

              this.$router.push({ path: '/solicitari/lista' });
            })
            .catch(error => {
              this.loading = false;

              console.log(error);
            })
            .finally(() => {

            });
        } else {
          this.loading = false;

          console.log('error submit!!');
          return false;
        }
      });
    },

    searchVoluntar(query){
      this.searchLoading = true;
      searchVolunteers(query, this.formData.solicitation.categories === 'alimente' ? 'livrator_alimente' : 'livrator_medicamente').then(resp => {
        this.searchLoading = false;
        this.volunteers = resp.volunteers;
      }).then(res => {
        this.searchLoading = false;
      });
    },

    searchCoordonator(query){
      this.searchLoading = true;
      searchVolunteers(query, 'coordonator').then(resp => {
        this.searchLoading = false;
        this.coordinators = resp.volunteers;
      }).then(res => {
        this.searchLoading = false;
      });
    },

  },
};
</script>

<style type="text/css" lang="scss" >

  .app-main{
    background: #eaeaea!important;
  }

  .add-wrapper{

    padding: 15px;

    .el-col{
      margin-bottom: 15px;
    }

    h3 {
      margin-top: 7px;
      margin-bottom: 7px;
    }

  .el-card__header {
    padding: 5px 10px!important;
  }

    .el-input-number__decrease {

      display: none;
    }

    .el-checkbox{
      width: 300px;
    }

    .checkbox-list {

      label{
        text-align: left!important;
        float: none!important;
        display: block!important;

      }
    }

    .intrebari-label {

      label {
        text-align: left;
        line-height: 20px;
      }
    }
  }

</style>
