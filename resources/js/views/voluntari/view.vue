<template>
  <el-form ref="volunteerFormName" :model="voluteerForm" class="volunteer-form">
    <el-row :gutter="20">
      <el-col :xs="24" :md="24" :sm="24" :lg="24">
        <el-card>
          <el-row>
            <el-col :xs="24" :md="6" :sm="6" :lg="6">

              <div class="volunteer-name">
                <div class="image">
                  <img data-v-152d8d58="" :src="voluteerForm.user.avatar ? voluteerForm.user.avatar : 'http://placekitten.com/g/200/300'" alt="user image" class="img-circle">
                </div>
                <div class="name-text">
                  <strong>{{ voluteerForm.name }}</strong><br>
                  <span>{{ voluteerForm.phone }}</span><br>
                  <span>{{ voluteerForm.email }}</span><br>

                </div>
              </div>

            </el-col>
            <el-col :xs="24" :md="3" :sm="3" :lg="3">
              <div style="text-align: center">
                <el-tag v-if="voluteerForm.ip_acord" type="success">Acord ISU Semnat</el-tag>
                <el-tag v-else type="warning">Acord ISU Nesemnat</el-tag>
                <p />
                <el-tag v-if="voluteerForm.ip_acord_voluntariat" type="success">Acord Voluntariat Semnat</el-tag>
                <el-tag v-else type="warning">Acord Voluntariat Nesemnat</el-tag>
              </div>
            </el-col>

            <el-col :xs="24" :md="3" :sm="3" :lg="3">
              <el-checkbox v-model="voluteerForm.verified">   <span v-if="voluteerForm.verified" style="color:green;margin: 3px"><i class="el-icon-success" /> Voluntar verificat</span>
                <span v-else style="color: red;margin: 3px"><i class="el-icon-warning" /> Necesita verificare </span></el-checkbox>

              <el-checkbox v-model="voluteerForm.has_traning"><span v-if="voluteerForm.has_traning" style="color:green;margin: 3px"><i class="el-icon-success" /> Trainig efectuat</span>
                <span v-else style="color: red;margin: 3px"><i class="el-icon-warning" /> Necesita training </span>  </el-checkbox>

            </el-col>

            <el-col :xs="24" :md="3" :sm="3" :lg="3">
              <el-form-item label="Rol in Organizatie" prop="type">
                <el-select v-model="voluteerForm.type" placeholder="rol">

                  <el-option label="Livrator Medicamente" value="livrator_medicamente" />
                  <el-option label="Livrator Alimente" value="livrator_alimente" />
                  <el-option label="Dispecer" value="dispecer" />
                  <el-option label="Coordonator voluntari" value="coordonator" />
                  <el-option label="Vizitator" value="viewer" />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :xs="24" :md="9" :sm="9" :lg="9">
              <div class="update-buttons">
                <el-button :icon="'el-icon-warning'" :type="'danger'" @click="deleteProfile">Sterge profilul</el-button>
                <el-button type="success" @click="update">Actualizare</el-button>

              </div>
            </el-col>

          </el-row>

        </el-card>
      </el-col>
      <el-col :xs="24" :md="8" :sm="8" :lg="8">

        <div class="container-form">
          <el-row :gutter="20">
            <el-col :xs="24" :md="24" :lg="24">
              <el-form-item label="Nume Complet" prop="name" :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }">
                <el-input v-model="voluteerForm.name" />
              </el-form-item>

              <el-form-item label="Email" prop="email" :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }">
                <el-input v-model="voluteerForm.email" />
              </el-form-item>

              <el-form-item label="Nr. Telefon" prop="phone" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">
                <el-input v-model="voluteerForm.phone" />
              </el-form-item>

              <el-form-item label="Varsta" prop="city" style="width: 100%" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">
                <el-select v-model="voluteerForm.age_range" filterable placeholder="Selecteaza varsta">
                  <el-option label="Sub 18 ani" value="<18" />
                  <el-option label="Intre 18 si 65 ani" value="18-65" />
                  <el-option label="Peste 65 ani" value="65+" />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :xs="24" :md="24" :lg="24">

              <el-row :gutter="20">

                <el-col :xs="24" :md="12" :lg="12">
                  <el-form-item label="Judet" prop="county" style="width: 100%" :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }">
                    <el-select v-model="voluteerForm.county" filterable placeholder="Selecteaza judetul" @change="getOraseJudet">
                      <el-option v-for="judet in judete" :key="judet.auto" :label="judet.nume" :value="judet.auto" />
                    </el-select>
                  </el-form-item>

                </el-col>
                <el-col :xs="24" :md="12" :lg="12">
                  <el-form-item label="Oras" prop="city" style="width: 100%" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">
                    <el-select v-model="voluteerForm.city" filterable placeholder="Selecteaza orasul">
                      <el-option v-for="(oras,index) in orase" :key="oras.nume+'-oras'+index" :label="oras.nume" :value="oras.nume" />
                    </el-select>
                  </el-form-item>
                </el-col>

                <el-col :xs="24" :md="12" :lg="12">

                  <el-form-item label="Strada pe care locuiesti" prop="address" :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }">
                    <el-input v-model="voluteerForm.address" />
                  </el-form-item>

                </el-col>
                <el-col :xs="12" :md="3" :lg="3">

                  <el-form-item label="Numar" prop="address_no" :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }">
                    <el-input v-model="voluteerForm.address_no" />
                  </el-form-item>

                </el-col>
                <el-col :xs="12" :md="3" :lg="3">

                  <el-form-item label="Bloc" prop="address_bl">
                    <el-input v-model="voluteerForm.address_bl" />
                  </el-form-item>

                </el-col>
                <el-col :xs="12" :md="3" :lg="3">

                  <el-form-item label="Scara" prop="address_sc">
                    <el-input v-model="voluteerForm.address_sc" />
                  </el-form-item>

                </el-col>

                <el-col :xs="12" :md="3" :lg="3">

                  <el-form-item label="Ap." prop="address_ap">
                    <el-input v-model="voluteerForm.address_ap" />
                  </el-form-item>

                </el-col>

              </el-row>
            </el-col>
          </el-row>
        </div>
        <div class="container-form">

          <el-form-item

            label="Cu ce te ocupi? Care este experiența ta de muncă pe scurt?"
            prop="screening_questions.occupations"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.occupations" type="textarea" />
          </el-form-item>

          <el-form-item
            label="Ai mai fost voluntar?"
            prop="screening_questions.volunteer_experience"
            :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
          >
            <el-radio-group v-model="voluteerForm.screening_questions.volunteer_experience">
              <el-radio label="Da">Da</el-radio>
              <el-radio label="Nu">Nu</el-radio>
            </el-radio-group>
          </el-form-item>

          <el-form-item
            v-if="voluteerForm.screening_questions.volunteer_experience ==='Da'"
            label="In ce proiecte? (alege-le pe cele mai relevante)"
            prop="screening_questions.volunteer_experience_details"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.volunteer_experience_details" type="textarea" />
          </el-form-item>

          <el-form-item
            v-if="voluteerForm.screening_questions.volunteer_experience ==='Da'"
            label="Ce rol ai avut? "
            prop="screening_questions.volunteer_experience_roles"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.volunteer_experience_roles" type="textarea" />
          </el-form-item>

        </div>

        <div class="container-form">

          <el-form-item
            label="Este ceva ce crezi că ar mai trebui să știm despre tine în acest context?"
            prop="screening_questions.other_volunteer_details"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.other_volunteer_details" type="textarea" />
          </el-form-item>

          <el-form-item
            label="Spune-ne ceva drăguț, avem mare nevoie!"
            prop="screening_questions.volunteer_nice_thoughts"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.volunteer_nice_thoughts" type="textarea" />
          </el-form-item>

        </div>

      </el-col>
      <el-col :xs="24" :md="8" :sm="8" :lg="8">

        <div class="container-form">
          <el-form-item prop="involvement_direction" label="Ce rol dorești să-ți asumi?" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">

            <el-radio-group v-model="voluteerForm.involvement_direction">
              <el-radio label="Call Center">Dispecer Call center - preia apeluri pe linia unică de dispecerat </el-radio>
              <el-radio label="Alimente">Livrator alimente</el-radio>
              <el-radio label="Medicamente">Livrator medicamente</el-radio>
            </el-radio-group>
          </el-form-item>

        </div>

        <div v-if="voluteerForm.involvement_direction !== 'Call Center'" class="container-form">
          <el-row :gutter="20">

            <el-col :xs="24" :md="24" :lg="24">
              <el-form-item prop="screening_questions.situatie_locuire" label="Situația locuirii - curentă și-n următoarele 3 luni" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }" class="checkbox-list">
                <el-checkbox-group v-model="voluteerForm.screening_questions.situatie_locuire">
                  <el-checkbox label="Locuiesc singur/ă" name="situatie_locuire" />
                  <el-checkbox label="Locuiesc împreună cu soț/soție/partener" name="situatie_locuire" />
                  <el-checkbox label="Locuiesc împreuna cu 3 sau mai multe persoane" name="situatie_locuire" />
                  <el-checkbox label="Locuiesc împreună cu copii sau persoane peste 65 de ani" name="situatie_locuire" />
                  <el-checkbox label="Locuiesc împreună cu persoane care suferă de boli cronice grave" name="situatie_locuire" />
                  <el-checkbox label="Locuiesc împreuna cu persoane care se deplasează recurent pentru a ajunge la locul de muncă" name="situatie_locuire" />

                </el-checkbox-group>

              </el-form-item>

              <div class="clearfix" />

              <el-form-item
                label="Ce părere are familia ta despre o posibilă implicare într-o acțiune de voluntariat care presupune riscul de contaminare cu Coronavirus."
                prop="screening_questions.parere_familie"

                :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
              >
                <el-input v-model="voluteerForm.screening_questions.parere_familie" type="textarea" />
              </el-form-item>
            </el-col>

          </el-row>

        </div>

        <div v-if="(voluteerForm.involvement_direction === 'Call Center')" class="container-form">

          <el-form-item

            label="Cum ai discuta cu un bătrân credincios și care tot repetă lucruri?"
            prop="screening_questions.dispatcher_question_1"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_1" type="text" />
          </el-form-item>

          <el-form-item

            label="Ce ai spune dacă un beneficiar plânge la telefon?"
            prop="screening_questions.dispatcher_question_2"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_2" type="text" />
          </el-form-item>

          <el-form-item

            label="Ce i-ai spune unei persoane care pare să aibă nevoie să vorbească, dar tu ai de lucru sau alte apeluri în așteptare?"
            prop="screening_questions.dispatcher_question_3"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_3" type="text" />
          </el-form-item>

          <el-form-item

            label="Care crezi că sunt cele mai importante calități ale unui dispecer?"
            prop="screening_questions.dispatcher_question_4"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_4" type="text" />
          </el-form-item>

          <el-form-item

            label="Ce părere ai despre faptul că-i ajutăm pe seniori?"
            prop="screening_questions.dispatcher_question_5"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_5" type="text" />
          </el-form-item>

          <el-form-item

            label="Ai mai lucrat cu clienții în orice formă?"
            prop="screening_questions.dispatcher_question_6"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.dispatcher_question_6" type="text" />
          </el-form-item>

        </div>

        <div class="container-form">

          <el-form-item
            label="Suntem în stare de urgență, autoritățile (poliția, poate armata) sunt pe stradă, ce părere ai despre asta?"
            prop="screening_questions.volunteer_opinion"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.volunteer_opinion" type="textarea" />
          </el-form-item>

          <el-form-item
            label="Care este starea ta de sănătate în acest moment?"
            prop="screening_questions.volunteer_symptoms"
            :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
          >
            <el-radio-group v-model="voluteerForm.screening_questions.volunteer_symptoms">
              <el-radio label="fara_simptom">Nu prezint nici un simptom de boală</el-radio>
              <el-radio label="cu_simptom">Am următoarele simptome</el-radio>
            </el-radio-group>
          </el-form-item>

          <el-form-item
            v-if="voluteerForm.screening_questions.volunteer_symptoms === 'cu_simptom'"
            label="Selecteaza simptomele"
            prop="screening_questions.volunteer_symptoms_details"
            :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
          >
            <el-checkbox-group v-model="voluteerForm.screening_questions.volunteer_symptoms_details">
              <el-checkbox label="Febră" name="volunteer_symptoms_details" />
              <el-checkbox label="Tuse" name="volunteer_symptoms_details" />
              <el-checkbox label="Dureri musculare" name="volunteer_symptoms_details" />
              <el-checkbox label="Durere de cap" name="volunteer_symptoms_details" />
              <el-checkbox label="Greutate respiratorie" name="volunteer_symptoms_details" />
              <el-checkbox label="Diaree" name="volunteer_symptoms_details" />
              <el-checkbox label="Altele" name="volunteer_symptoms_details" />

            </el-checkbox-group>

          </el-form-item>

          <el-form-item
            label="Știi să suferi de vreo afecțiune? Dacă da, care?"
            prop="screening_questions.other_volunteers_affections"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.other_volunteers_affections" type="textarea" />
          </el-form-item>

        </div>

      </el-col>
      <el-col :xs="24" :md="8" :sm="8" :lg="8">

        <div v-if="(voluteerForm.involvement_direction !== 'Call Center')" class="container-form">

          <el-row :gutter="20">
            <el-col :xs="24" :md="24" :lg="24">
              <el-form-item prop="transportation_options" label="Mijloc de transport" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">
                <el-radio-group v-model="voluteerForm.transportation_options">
                  <el-radio label="Masina">Am mașină proprie cu care mă pot deplasa pentru proiect</el-radio>
                  <el-radio label="Motocicleta">Am motocicleta proprie cu care mă pot deplasa pentru proiect</el-radio>
                  <el-radio label="Alt Mijloc">Am bicicleta/trotineta/scuter cu care mă pot deplasa pentru proiect</el-radio>

                </el-radio-group>
              </el-form-item>

              <el-form-item
                v-if="voluteerForm.transportation_options ==='Masina' || voluteerForm.transportation_options ==='Motocicleta'"
                label="Numar masina/motocicleta"
                prop="car_plates"
                :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
              >
                <el-input v-model="voluteerForm.car_plates" type="text" />
              </el-form-item>

              <el-form-item prop="screening_questions.transport_scopes" label="În ce alt scop folosești mijlocul de transport" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">
                <el-radio-group v-model="voluteerForm.screening_questions.transport_scopes">
                  <el-radio label="Livrat marfă">Livrat marfă</el-radio>
                  <el-radio label="Transport persoane cu care nu locuiesc">Transport persoane cu care nu locuiesc</el-radio>
                  <el-radio label="Pentru altele">Pentru altele</el-radio>
                </el-radio-group>
              </el-form-item>

              <el-form-item
                v-if="voluteerForm.screening_questions.transport_scopes === 'Pentru altele'"
                label="Descrie scopul"
                prop="screening_questions.transport_scopes_description"
                :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
              >
                <el-input v-model="voluteerForm.screening_questions.transport_scopes_description" type="textarea" />
              </el-form-item>

            </el-col>
          </el-row>

        </div>

        <div class="container-form">

          <el-form-item

            label="Care crezi ca sunt riscurile pe care le prezintă rolul ales?"
            prop="screening_questions.risks_involved"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.risks_involved" type="textarea" />
          </el-form-item>

          <el-form-item

            label="Care este cel mai mare risc pe care îl vezi și ești dispus să ți-l asumi?"
            prop="screening_questions.risks_involved"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.risks_assumed" type="textarea" />
          </el-form-item>

          <el-form-item

            label="Care sunt așteptările tale de la activitatea de voluntar?"
            prop="screening_questions.expectations"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.expectations" type="textarea" />
          </el-form-item>

          <el-form-item

            label="Care sunt așteptările de la organizatorii acestei inițiative?"
            prop="screening_questions.expectations_for_organisation"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.expectations_for_organisation" type="textarea" />
          </el-form-item>

          <el-form-item

            label="Care este motivatia ta de a te implica in acest proiect?"
            prop="screening_questions.motivation_for_the_project"
            :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
          >
            <el-input v-model="voluteerForm.screening_questions.motivation_for_the_project" type="textarea" />
          </el-form-item>

          <el-form-item

            label="Vor fi lucruri pe care nu le știm acum, cât de deschis ești spre schimbare rapidă și adaptare la contexte noi ( 1 foarte puțin deschis - 10 foarte deschis )"
            prop="screening_questions.change_adaptation"
            :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
          >
            <el-radio-group v-model="voluteerForm.screening_questions.change_adaptation" class="left-radio-button">
              <el-radio label="1">1</el-radio>
              <el-radio label="2">2</el-radio>
              <el-radio label="3">3</el-radio>
              <el-radio label="4">5</el-radio>
              <el-radio label="6">6</el-radio>
              <el-radio label="7">7</el-radio>
              <el-radio label="8">8</el-radio>
              <el-radio label="9">9</el-radio>
              <el-radio label="10">10</el-radio>

            </el-radio-group>
          </el-form-item>

        </div>

      </el-col>

    </el-row>
  </el-form>
</template>

<script>
import Resource from '@/api/resource';
import axios from 'axios';
const volunteersResource = new Resource('volunteers');
export default {
  name: 'ViewVolunteer',

  data(){
    return {
      judete: [],
      orase: [],
      voluteerForm: {
        acord: {
          acordIsu: false,
          acordVoluntariat: false,
        },
        acord_termeni: '',
        verified: false,
        has_traning: false,
        name: '',
        email: '',
        phone: '',
        age_range: '',
        county: 'CJ',
        city: '',
        address: '',
        address_no: '',
        address_bl: '',
        address_sc: '',
        address_ap: '',
        involvement_direction: '',
        transportation_options: '',
        car_plates: '',
        screening_questions: {
          situatie_locuire: [],
          parere_familie: '',
          transport_scopes: '',
          dispatcher_question_1: '',
          dispatcher_question_2: '',
          dispatcher_question_3: '',
          dispatcher_question_4: '',
          dispatcher_question_5: '',
          dispatcher_question_6: '',
          risks_assumed: '',
          risks_involved: '',
          expectations: '',
          expectations_for_organisation: '',
          motivation_for_the_project: '',
          change_adaptation: '',
          occupations: '',
          volunteer_experience: '',
          volunteer_experience_details: '',
          volunteer_experience_roles: '',
          volunteer_opinion: '',
          volunteer_symptoms: '',
          volunteer_symptoms_details: [],
          other_volunteers_affections: '',
          other_volunteer_details: '',
          volunteer_nice_thoughts: '',

        },
        ci: '',
        cnp: '',
        loc_domiciliu: '',
        str_domiciliu: '',
        nr_domiciliu: '',
        ap_domiciliu: '',
        ip_acord_voluntariat: '',
        ip_acord: '',

      },
    };
  },

  mounted(){
    this.getOraseJudet();
    this.getVolunteer();
  },

  methods: {
    getVolunteer(){
      volunteersResource.get(this.$route.params.id).then(res => {
        this.voluteerForm = { ...this.voluteerForm, ...res.volunteer };

        if (!this.voluteerForm.screening_questions){
          this.voluteerForm.screening_questions = {
            situatie_locuire: [],
            parere_familie: '',
            transport_scopes: '',
            dispatcher_question_1: '',
            dispatcher_question_2: '',
            dispatcher_question_3: '',
            dispatcher_question_4: '',
            dispatcher_question_5: '',
            dispatcher_question_6: '',
            risks_assumed: '',
            risks_involved: '',
            expectations: '',
            expectations_for_organisation: '',
            motivation_for_the_project: '',
            change_adaptation: '',
            occupations: '',
            volunteer_experience: '',
            volunteer_experience_details: '',
            volunteer_experience_roles: '',
            volunteer_opinion: '',
            volunteer_symptoms: '',
            volunteer_symptoms_details: [],
            other_volunteers_affections: '',
            other_volunteer_details: '',
            volunteer_nice_thoughts: '',

          };
        }
      });
    },
    getOraseJudet(){
      axios.get('https://roloca.coldfuse.io/orase/' + this.voluteerForm.county).then(resp => {
        this.orase = resp.data;
      });
    },

    update(){
      this.loading = true;
      volunteersResource
        .update(this.voluteerForm.id, this.voluteerForm)
        .then(response => {
          this.$message({
            message: 'Datele au fost actualizate',
            type: 'success',
            duration: 5 * 1000,
          });

          this.loading = false;
          this.$router.push('/voluntari/list');
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    deleteProfile(){
      this.$confirm('Profilul și toate datele introduse vor fi șterse.', 'Atentie!!!', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        beforeClose: (action, instance, done) => {
          if (action === 'confirm') {
            volunteersResource.destroy(this.voluteerForm.id).then(response => {
              this.$router.push('/voluntari/list');
            });
            done();
          } else {
            done();
          }
        },
      }).then(() => {
        this.$message({
          type: 'success',
          message: 'Voluntarul a fost sters',
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Stergerea s-a anulat',
        });
      });
    },
  },
};
</script>

<style lang="scss" >

  .volunteer-form{

    padding: 15px;

  .container-form {

    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 15px;
    background: #fbfbfb;

    max-width: 650px;
    margin: 20px auto;

  }

  .el-select {

    width: 100%!important;
  }

  .el-form-item {

  label{

    padding: 0!important;
  }
  }

  .el-radio-group {

  label {
    display: block;
  }
  }

  .el-checkbox {
    display: block;
  }
  .el-form-item__content {
    clear: both!important;
  }
  .el-form-item__label{
    text-align: left;
  }

  .el-form-item--medium .el-form-item__content { clear: both!important; }

  .el-steps--horizontal {
    max-width: 660px;
    margin: 0 auto;
  }

  .checkbox-list {

  label{
    text-align: left!important;
    float: none!important;
    display: block!important;

  }
  }

  .el-form-item--medium .el-form-item__label {

    float: none!important;
    text-align: left!important;
    line-height: 25px;
  }

  .el-radio {
    line-height: 25px!important;
  }

  .left-radio-button {

  label {
    display: inline-block!important;
  }

  }
  .el-button {
    margin-top: 10px;
  }

    .volunteer-name {

      .image {

        display: block;
        float: left;

      }
      img {

        cursor: pointer;
        width: 50px;
        height: 50px;
        border-radius: 50px;
      }

      .name-text{

        text-align: left;
        margin-left: 10px;
        display: block;
        float: left;
      }

    }

    .update-buttons {
      display: flex;
      flex-direction: row;
      flex-flow: row-reverse;
      button {
        margin-left: 10px;
      }
    }

  }
</style>
