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
                <el-select v-model="formData.beneficiar.county" style="width: 100%;" filterable placeholder="Selecteaza judetul" @change="getOraseJudet">
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
                  message: 'Este necesar orasul',
                  trigger: 'blur'
                }"
              >
                <el-select v-model="formData.beneficiar.city" style="width: 100%;" filterable placeholder="Selecteaza orasul">
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
                  <el-option label="14 Mai" value="14 Mai" />
                  <el-option label="Carpati I" value="Carpati I" />
                  <el-option label="Carpati II" value="Carpati II" />
                  <el-option label="Centru Nou" value="Centru Nou" />
                  <el-option label="Closca" value="Closca" />
                  <el-option label="Crisan" value="Crisan" />
                  <el-option label="Micro 17" value="Micro 17" />
                  <el-option label="Horea" value="Horea" />
                  <el-option label="Menumorut" value="Menumorut" />
                  <el-option label="Satmarel" value="Satmarel" />
                  <el-option label="Soarelui" value="Soarelui" />
                  <el-option label="Solidaritatii" value="Solidaritatii" />
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

                <el-autocomplete

                  v-model="formData.beneficiar.phone"
                  style="width: 100%"
                  clearable
                  :fetch-suggestions="searchOldOrders"
                  placeholder="Scrie numar"
                  value-key="phone"
                  @select="handleSelect"
                >
                  <template slot-scope="{ item }">
                    <p class="search-results"> <strong class="value">{{ item.first_name }} {{ item.first_name }}</strong> </p>
                    <p class="search-results">{{ item.phone }}</p>
                  </template>

                </el-autocomplete>

              </el-form-item>

              <div v-if="lastOrder">Ultima comanda: <a target="_blank" style="color: darkblue" :href="'/#/solicitari/edit/2'"> #{{ lastOrder.code }} - acum {{ new Date(lastOrder.created_at).getTime()/1000 | timeAgo }} </a> </div>
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
              v-for="(intrebare) in intrebari.intrebariStabilireUrgenta"
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
              <el-option label="Altele" value="altele" />

            </el-select>

          </el-form-item>

          <div v-if="formData.solicitation.categories==='altele'">

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Descriere nevoie"
                prop="solicitation.additional_responses.altele_descriere_nevoie"
              >

                <el-input v-model="formData.solicitation.additional_responses.altele_descriere_nevoie" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
              </el-form-item>
            </el-col>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Recomandare dispecer"
                prop="solicitation.additional_responses.altele_recomandare_dispecer"
              >

                <el-input v-model="formData.solicitation.additional_responses.altele_recomandare_dispecer" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
              </el-form-item>
            </el-col>

            <el-col :span="12" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Solutie agreată"
                prop="solicitation.additional_responses.altele_solutie_agreata"
              >

                <el-input v-model="formData.solicitation.additional_responses.altele_solutie_agreeata" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
              </el-form-item>
            </el-col>

          </div>

          <div
            class="clearfix"
            style="display: block;
    width: 5px;"
          ><br></div>

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
                <el-option v-for="pachet in pacheteAlimente" :key="pachet.key" :label="pachet.label+' aprox. '+pachet.price+' RON - '+ calculatePercent(pachet.price)+' RON'" :value="pachet.key" />
                <el-option label="Pachet personalizat - max 8 produse " value="personalizat" />
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

            <div>

              <el-form-item label="Condimente" class="checkbox-list">
                <el-checkbox-group v-model="formData.solicitation.additional_responses.condimente" :max="2">
                  <el-checkbox v-for="produs in Condimente" :key="produs.key" :label="produs.label" name="condimente" :value="produs.key" @change="calculPret" />

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

          <div v-if="formData.solicitation.categories === 'alimente'" class="price-estimation">

            <p>Pret final estimativ intre <strong>{{ formData.solicitation.payment_value }} RON</strong> si <strong>{{ calculatePercent(formData.solicitation.payment_value) }} RON</strong></p>
          </div>

          <div v-if="formData.solicitation.categories !== 'altele'">
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
                label="Pret final"
                prop="solicitation.payment_value"
              >

                <el-input-number v-model="formData.solicitation.payment_value" :precision="2" :step="5" />

              </el-form-item>
            </el-col>
          </div>

          <div v-if="formData.solicitation.categories !=='altele'">

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
            <el-col :span="24" :xs="24" style="margin-bottom: 5px">
              <el-form-item
                label="Aloca unui coordonator"
                prop="solicitation.coordonator_id"
              >

                <el-select
                  v-model="formData.solicitation.coordonator_id"
                  v-role="['admin', 'coordonator', 'dispecer']"
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
                    :key="'vol'+item.id"
                    :label="item.name + ' ( '+item.phone+' )'"
                    :value="item.id"
                  />

                </el-select>

              </el-form-item>
            </el-col>
          </div>

          <el-col :span="24" :xs="24" style="margin-bottom: 5px">
            <el-button :loading="loading" type="primary" class="pull-right" @click="add">Adauga Solicitare</el-button>
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
import { pachete as pacheteAlimente, produsePachetPersonalizat, produseAditionale, Condimente } from './data/pachete-alimente';
import { mapGetters } from 'vuex';
import Resource from '@/api/resource';

import { searchVolunteers, searchBeneficiaries } from '@/api/search';
import role from '@/directive/role/index.js';

const solicitationsResource = new Resource('solicitations');
export default {
  name: 'AddSolicitatin',
  directives: { role },
  data: () => {
    return {
      searchLoading: false,
      coordinators: [],
      judete: [],
      orase: [],
      lastOrder: '',
      loading: false,
      formData: {
        beneficiar: {
          additional_responses: {},
          first_name: '',
          last_name: '',
          city: 'Satu Mare',
          county: 'SM',
          address: '',
          neighborhood: '',
          phone: '',
          observations: '',
        },
        solicitation: {
          additional_responses: {
            tip_cos: '',
            cos_personalizat: [],
            produse_aditionale: [],
            condimente: [],

          },
          payment_value: 0,
          payment_type: 'plata_cash',
          payment_status: 'Neachitat',
          status: 'necesita_voluntar',
          emergency: 'normal',
          categories: '',
          volunteer_id: '',
          coordonator_id: '',
        },
      },
      intrebari,
      pacheteAlimente,
      produsePachetPersonalizat,
      produseAditionale,
      Condimente,
    };
  },

  computed: {
    ...mapGetters([
      'roles',

    ]),

  },

  watch: {
    'formData.solicitation.additional_responses.tip_cos'(val){
      if (val === 'personalizat' || val === 'nada') {
        if (!this.formData.solicitation.additional_responses.produse_aditionale.find(r => r === 'Sacosa [1buc | Cora] - 5,00RON')){
          this.formData.solicitation.additional_responses.produse_aditionale.push('Sacosa [1buc | Cora] - 5,00RON');
        }
      } else {
        this.formData.solicitation.additional_responses.produse_aditionale = this.formData.solicitation.additional_responses.produse_aditionale.filter(item => item !== 'Sacosa [1buc | Cora] - 5,00RON');
      }

      this.calculPret();
    },
  },

  mounted(){
    axios.get('https://roloca.coldfuse.io/judete').then(resp => {
      this.judete = resp.data;
    });
    this.getOraseJudet();
  },

  methods: {
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

      if (this.formData.solicitation.additional_responses.condimente){
        this.formData.solicitation.additional_responses.condimente.forEach(res => {
          const produs = this.Condimente.find(r => r.label === res);
          if (produs){
            priceArray.push(parseFloat(produs.price));
          }
        });
      } else {
        this.formData.solicitation.additional_responses.condimente = [];
      }

      this.formData.solicitation.payment_value = priceArray.reduce((a, b) => a + b, 0).toFixed(2);
    },
    add(){
      this.loading = true;

      this.$refs['addForm'].validate((valid) => {
        if (valid) {
          solicitationsResource
            .store(this.formData)
            .then(response => {
              this.loading = false;

              this.$message({
                type: 'success',
                message: 'Solicitare a fost adaugata',
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

    searchOldOrders(queryString, cb){
      searchBeneficiaries(queryString).then(results => {
        cb(results);
      });
    },

    handleSelect(option){
      console.log(option);

      this.formData.beneficiar = option;

      this.lastOrder = option.solicitation.length > 0 ? option.solicitation[0] : '';
    },

    searchCoordonator(query){
      this.seaarchLoading = true;
      searchVolunteers(query, 'coordonator').then(resp => {
        this.seaarchLoading = false;
        this.coordinators = resp.volunteers;
      }).then(res => {
        this.seaarchLoading = false;
      });
    },
    calculatePercent(amount, percent = 1.3){
      return parseFloat(amount * percent).toFixed(2);
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

  .search-results {
    margin: 3px;
    line-height: 12px;
  }

  .price-estimation {
    text-align: center;
    border: 1px solid;
    padding: 5px;
    width: 450px;
    margin: 10px auto;
    background: #00ff4e;
  }

</style>
