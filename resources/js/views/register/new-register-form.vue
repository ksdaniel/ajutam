<template>
  <el-card class="form-wrapper">
    <div slot="header">
      <h3>Inregistreaza-te ca voluntar</h3>
    </div>
    <el-row>
      <el-col :xs="24" :md="24" :lg="24">
        <el-steps direction="horizontal" :active="active">
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step title />
          <el-step v-if="voluteerForm.involvement_direction !== 'Call Center'" title />
        </el-steps>
      </el-col>

      <el-col :xs="24" :md="24" :lg="24">
        <div v-if="active===0" class="container-form">
          <p>
            Înainte de a completa acest formular, te rugăm să citești cu atenție toate informațiile de pe
            <a href="http://wwww.ajutamsm.ro/" target="_blank">www.ajutamsm.ro</a>
          </p>

          <p>
            Iți vom cere mai multe informații pentru că, în contextul riscurilor mari din activitatea noastră, trebuie să știm toate aceste lucruri despre tine.
            Durează 10-15 minute, și apoi ne poți ajuta să ajutăm.
          </p>

          <p>Vrem să știi că datele tale sunt protejate și nu le vom folosi în nici un scop comercial sau de marketing, altul decât acela de a ne da seama dacă ești pregătit/ă să ne ajuți în acest context riscant și să fim siguri că putem reduce împreună riscurile de contaminare și pentru tine, apropiatii tai și pentru beneficiari.</p>
          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="success" @click="next()">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div v-if="active===1" class="container-form">
          <h4>Termeni și condiții</h4>
          <p>
            Utilizarea platformei
            <a href="https://voluntari.ajutamsm.ro/">voluntari.ajutamsm.ro/</a> presupune colectarea datelor de identificare necesare (nume, prenume și număr de telefon, adresă, email) pentru ca echipa de coordonare să poată să verifice și să proceseze cererea dumneavoastră de &icirc;nscriere ca voluntari sau beneficiari.&nbsp;
          </p>
          <p>Fără aceste date, solicitările dvs nu pot fi validate.</p>
          <p>Datele furnizate platformei vor fi folosite de către voluntarii acesteia pentru identificarea utilizatorilor și pentru coordonarea răspunsului la toate solicitările venite.</p>
          <p>Nu vor fi folosite &icirc;n nici un scop comercial sau generator de profit, nu vor fi v&acirc;ndute sau oferite nici unei alte entități.</p>
          <p>Platforma este o resursă deschisă, pusă la dispoziție cu titlu gratuit pentru facilitarea interacțiunii &icirc;ntre oamenii care au nevoie de ajutor și resurse și cei care pot să le ofere.</p>

          <el-form ref="terms-form" :model="voluteerForm">
            <el-form-item
              prop="acord_termeni"
              :rules="{ type: 'boolean', required: true, trigger: 'change', message: 'Trebuie sa accepti termenii si conditiile' }"
            >
              <el-checkbox
                v-model="voluteerForm.acord_termeni"
                label="Sunt de acord cu termenii si conditiile"
                name="acord_termeni"
              />
            </el-form-item>
          </el-form>
          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('terms-form')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div v-if="active===2" class="container-form">
          <el-form ref="contactForm" :model="voluteerForm">
            <el-row :gutter="20">
              <el-col :xs="24" :md="24" :lg="24">
                <el-form-item
                  label="Nume Complet"
                  prop="name"
                  :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                >
                  <el-input v-model="voluteerForm.name" />
                </el-form-item>

                <el-form-item
                  label="Email"
                  prop="email"
                  :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                >
                  <el-input v-model="voluteerForm.email" />
                </el-form-item>

                <el-form-item
                  label="Nr. Telefon"
                  prop="phone"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                >
                  <el-input v-model="voluteerForm.phone" />
                </el-form-item>

                <el-form-item
                  label="Varsta"
                  prop="city"
                  style="width: 100%"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                >
                  <el-select
                    v-model="voluteerForm.age_range"
                    filterable
                    placeholder="Selecteaza varsta"
                  >
                    <el-option label="Sub 18 ani" value="<18" />
                    <el-option label="Intre 18 si 65 ani" value="18-65" />
                    <el-option label="Peste 65 ani" value="65+" />
                  </el-select>
                </el-form-item>
              </el-col>

              <el-col :xs="24" :md="24" :lg="24">
                <el-row :gutter="20">
                  <el-col :xs="24" :md="12" :lg="12">
                    <el-form-item
                      label="Judet"
                      prop="county"
                      style="width: 100%"
                      :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                    >
                      <el-select
                        v-model="voluteerForm.county"
                        filterable
                        placeholder="Selecteaza judetul"
                        @change="getOraseJudet"
                      >
                        <el-option
                          v-for="judet in judete"
                          :key="judet.auto"
                          :label="judet.nume"
                          :value="judet.auto"
                        />
                      </el-select>
                    </el-form-item>
                  </el-col>
                  <el-col :xs="24" :md="12" :lg="12">
                    <el-form-item
                      label="Oras"
                      prop="city"
                      style="width: 100%"
                      :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                    >
                      <el-select
                        v-model="voluteerForm.city"
                        filterable
                        placeholder="Selecteaza orasul"
                      >
                        <el-option
                          v-for="(oras,index) in orase"
                          :key="oras.nume+'-oras'+index"
                          :label="oras.nume"
                          :value="oras.nume"
                        />
                      </el-select>
                    </el-form-item>
                  </el-col>

                  <el-col :xs="24" :md="12" :lg="12">
                    <el-form-item
                      label="Strada pe care locuiesti"
                      prop="address"
                      :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                    >
                      <el-input v-model="voluteerForm.address" />
                    </el-form-item>
                  </el-col>
                  <el-col :xs="12" :md="3" :lg="3">
                    <el-form-item
                      label="Numar"
                      prop="address_no"
                      :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                    >
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
          </el-form>
          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button
              :disabled="voluteerForm.age_range !=='18-65'"
              type="success"
              @click="next('contactForm')"
            >
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div v-if="active===3" class="container-form">
          <el-form ref="implicationForm" :model="voluteerForm">
            <el-row :gutter="20">
              <el-col :xs="24" :md="24" :lg="24">
                <el-form-item
                  prop="involvement_direction"
                  label="Ce rol dorești să-ți asumi?"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                >
                  <el-radio-group v-model="voluteerForm.involvement_direction">
                    <el-radio
                      label="Call Center"
                    >Dispecer Call center - preia apeluri pe linia unică de dispecerat</el-radio>
                    <el-radio label="Alimente">Livrator alimente</el-radio>
                    <el-radio label="Medicamente">Livrator medicamente</el-radio>
                  </el-radio-group>
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('implicationForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="active===4 && voluteerForm.involvement_direction !== 'Call Center'"
          class="container-form"
        >
          <el-form ref="transportatorForm" :model="voluteerForm">
            <el-row :gutter="20">
              <el-col :xs="24" :md="24" :lg="24">
                <el-form-item
                  prop="screening_questions.situatie_locuire"
                  label="Situația locuirii - curentă și-n următoarele 3 luni"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                  class="checkbox-list"
                >
                  <el-checkbox-group v-model="voluteerForm.screening_questions.situatie_locuire">
                    <el-checkbox label="Locuiesc singur/ă" name="situatie_locuire" />
                    <el-checkbox
                      label="Locuiesc împreună cu soț/soție/partener"
                      name="situatie_locuire"
                    />
                    <el-checkbox
                      label="Locuiesc împreuna cu 3 sau mai multe persoane"
                      name="situatie_locuire"
                    />
                    <el-checkbox
                      label="Locuiesc împreună cu copii sau persoane peste 65 de ani"
                      name="situatie_locuire"
                    />
                    <el-checkbox
                      label="Locuiesc împreună cu persoane care suferă de boli cronice grave"
                      name="situatie_locuire"
                    />
                    <el-checkbox
                      label="Locuiesc împreuna cu persoane care se deplasează recurent pentru a ajunge la locul de muncă"
                      name="situatie_locuire"
                    />
                  </el-checkbox-group>
                </el-form-item>

                <div class="clearfix" />

                <el-form-item
                  label="Ce părere are familia ta despre o posibilă implicare într-o acțiune de voluntariat care presupune riscul de contaminare cu Coronavirus."
                  prop="screening_questions.parere_familie"
                  :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                >
                  <el-input
                    v-model="voluteerForm.screening_questions.parere_familie"
                    type="textarea"
                  />
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('transportatorForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===5 && voluteerForm.involvement_direction !== 'Call Center')"
          class="container-form"
        >
          <el-form ref="hascarForm" :model="voluteerForm">
            <el-row :gutter="20">
              <el-col :xs="24" :md="24" :lg="24">
                <el-form-item
                  prop="transportation_options"
                  label="Mijloc de transport"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                >
                  <el-radio-group v-model="voluteerForm.transportation_options">
                    <el-radio label="Masina">Am mașină proprie cu care mă pot deplasa pentru proiect</el-radio>
                    <el-radio
                      label="Motocicleta"
                    >Am motocicleta proprie cu care mă pot deplasa pentru proiect</el-radio>
                    <el-radio
                      label="Alt Mijloc"
                    >Am bicicleta/trotineta/scuter cu care mă pot deplasa pentru proiect</el-radio>
                  </el-radio-group>
                </el-form-item>


                <!--

                <el-form-item
                  v-if="voluteerForm.transportation_options ==='Masina' || voluteerForm.transportation_options ==='Motocicleta'"
                  label="Numar masina/motocicleta"
                  prop="car_plates"
                  :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                >
                  <el-input v-model="voluteerForm.car_plates" type="text" />
                </el-form-item>

                -->

                <el-form-item
                  prop="screening_questions.transport_scopes"
                  label="În ce alt scop folosești mijlocul de transport"
                  :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
                >
                  <el-radio-group v-model="voluteerForm.screening_questions.transport_scopes">
                    <el-radio label="Livrat marfă">Livrat marfă</el-radio>
                    <el-radio
                      label="Transport persoane cu care nu locuiesc"
                    >Transport persoane cu care nu locuiesc</el-radio>
                    <el-radio label="Pentru altele">Pentru altele</el-radio>
                  </el-radio-group>
                </el-form-item>

                <el-form-item
                  v-if="voluteerForm.screening_questions.transport_scopes === 'Pentru altele'"
                  label="Descrie scopul"
                  prop="screening_questions.transport_scopes_description"
                  :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
                >
                  <el-input
                    v-model="voluteerForm.screening_questions.transport_scopes_description"
                    type="textarea"
                  />
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('hascarForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===4 && voluteerForm.involvement_direction === 'Call Center')"
          class="container-form"
        >

          <el-form ref="dispatcherScreeningForm" :model="voluteerForm">

        <!--
            <el-form-item
              label="Cum ai discuta cu un bătrân credincios și care tot repetă lucruri?"
              prop="screening_questions.dispatcher_question_1"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_1"
                type="text"
              />
            </el-form-item>

          -->

            <el-form-item
              label="Ce ai spune dacă un beneficiar plânge la telefon?"
              prop="screening_questions.dispatcher_question_2"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_2"
                type="text"
              />
            </el-form-item>

            <el-form-item
              label="Ce i-ai spune unei persoane care pare să aibă nevoie să vorbească, dar tu ai de lucru sau alte apeluri în așteptare?"
              prop="screening_questions.dispatcher_question_3"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_3"
                type="text"
              />
            </el-form-item>


            <!--

            <el-form-item
              label="Care crezi că sunt cele mai importante calități ale unui dispecer?"
              prop="screening_questions.dispatcher_question_4"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_4"
                type="text"
              />
            </el-form-item>

            <el-form-item
              label="Ce părere ai despre faptul că-i ajutăm pe seniori?"
              prop="screening_questions.dispatcher_question_5"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_5"
                type="text"
              />
            </el-form-item>

            -->

            <el-form-item
              label="Ai mai lucrat cu clienții în orice formă?"
              prop="screening_questions.dispatcher_question_6"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.dispatcher_question_6"
                type="text"
              />
            </el-form-item>
          </el-form>
          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('dispatcherScreeningForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===5 && voluteerForm.involvement_direction === 'Call Center') || (active===6 && voluteerForm.involvement_direction !== 'Call Center')"
          class="container-form"
        >
          <el-form ref="screeningForm" :model="voluteerForm">
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
              <el-input
                v-model="voluteerForm.screening_questions.expectations_for_organisation"
                type="textarea"
              />
            </el-form-item>

            <el-form-item
              label="Care este motivatia ta de a te implica in acest proiect?"
              prop="screening_questions.motivation_for_the_project"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.motivation_for_the_project"
                type="textarea"
              />
            </el-form-item>

            <el-form-item
              label="Vor fi lucruri pe care nu le știm acum, cât de deschis ești spre schimbare rapidă și adaptare la contexte noi ( 1 foarte puțin deschis - 10 foarte deschis )"
              prop="screening_questions.change_adaptation"
              :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }"
            >
              <el-radio-group
                v-model="voluteerForm.screening_questions.change_adaptation"
                class="left-radio-button"
              >
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
          </el-form>
          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('screeningForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===6 && voluteerForm.involvement_direction === 'Call Center') || (active===7 && voluteerForm.involvement_direction !== 'Call Center')"
          class="container-form"
        >
          <el-form ref="experienceForm" :model="voluteerForm">
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
              <el-input
                v-model="voluteerForm.screening_questions.volunteer_experience_details"
                type="textarea"
              />
            </el-form-item>

            <el-form-item
              v-if="voluteerForm.screening_questions.volunteer_experience ==='Da'"
              label="Ce rol ai avut? "
              prop="screening_questions.volunteer_experience_roles"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.volunteer_experience_roles"
                type="textarea"
              />
            </el-form-item>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('experienceForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===7 && voluteerForm.involvement_direction === 'Call Center') || (active===8 && voluteerForm.involvement_direction !== 'Call Center')"
          class="container-form"
        >
          <el-form ref="healthScreeningForm" :model="voluteerForm">

            <!--
            <el-form-item
              label="Suntem în stare de urgență, autoritățile (poliția, poate armata) sunt pe stradă, ce părere ai despre asta?"
              prop="screening_questions.volunteer_opinion"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.volunteer_opinion"
                type="textarea"
              />
            </el-form-item>
            -->

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
              <el-checkbox-group
                v-model="voluteerForm.screening_questions.volunteer_symptoms_details"
              >
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
              <el-input
                v-model="voluteerForm.screening_questions.other_volunteers_affections"
                type="textarea"
              />
            </el-form-item>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('healthScreeningForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===8 && voluteerForm.involvement_direction === 'Call Center') || (active===9 && voluteerForm.involvement_direction !== 'Call Center')"
          class="container-form"
        >
          <el-form ref="endForm" :model="voluteerForm">
            <el-form-item
              label="Este ceva ce crezi că ar mai trebui să știm despre tine în acest context?"
              prop="screening_questions.other_volunteer_details"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.other_volunteer_details"
                type="textarea"
              />
            </el-form-item>

            <el-form-item
              label="Spune-ne ceva drăguț, avem mare nevoie!"
              prop="screening_questions.volunteer_nice_thoughts"
              :rules="{ required: true, trigger: 'blur', message: 'Campul trebuie completat' }"
            >
              <el-input
                v-model="voluteerForm.screening_questions.volunteer_nice_thoughts"
                type="textarea"
              />
            </el-form-item>

            <p>Noi îți spunem că decizia ta de implicare are efecte asupra celor mai vulnerabili oameni acum și fiecare om la care ajungem e un ajutor uriaș!</p>
          </el-form>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('endForm')">
              Urmatorul pas
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div
          v-if="(active===9 && voluteerForm.involvement_direction === 'Call Center') || (active===10 && voluteerForm.involvement_direction !== 'Call Center' )"
          class="container-form"
        >
          <div style="text-align: center">
            <h3>Ultimul pas, este necesar sa semnezi 2 declaratii pe proprie raspundere</h3>
          </div>
          <div class="declaratii-wrapper">
            <el-button
              :icon="(voluteerForm.ip_acord_voluntariat || voluteerForm.acord.acordVoluntariat) ? 'el-icon-success' : 'el-icon-warning'"
              :type="(voluteerForm.ip_acord_voluntariat || voluteerForm.acord.acordVoluntariat) ? 'success' : 'warning'"
              @click="centerDialogVisibleVoluntariat=true"
            >{{ (voluteerForm.ip_acord_voluntariat || voluteerForm.acord.acordVoluntariat) ? 'Vezi' : 'Semneaza' }} Declaratie Voluntariat</el-button>
            <el-button
              :icon="( voluteerForm.ip_acord || voluteerForm.acord.acordIsu) ? 'el-icon-success' : 'el-icon-warning'"
              :type="( voluteerForm.ip_acord || voluteerForm.acord.acordIsu) ? 'success' : 'warning'"
              @click="centerDialogVisible=true"
            >{{ ( voluteerForm.ip_acord || voluteerForm.acord.acordIsu)? 'Vezi' : 'Semneaza' }} declaratie pe proprie raspundere</el-button>
          </div>

          <div class="buttons-wrapper">
            <el-button type="danger" @click="cancel">
              <i class="el-icon-error" />Anuleaza
            </el-button>
            <el-button type="warning" @click="back">
              <i class="el-icon-d-arrow-left" />Inapoi
            </el-button>
            <el-button type="success" @click="next('declaratiiForm')">
              Finalizare
              <i class="el-icon-d-arrow-right" />
            </el-button>
          </div>
        </div>

        <div v-if="(active===10 && voluteerForm.involvement_direction === 'Call Center') || (active===11 && voluteerForm.involvement_direction !== 'Call Center' )" class="container-form">


          <div style="text-align: center">
            <h3>Iti multumim pentru completare</h3>
            <h4>Uite ce poti face de aici:</h4>
          </div>

          <ul>
            <li>Ești invitat să parcurgi și să studiezi cu atenție detaliile despre ce facem &icirc;n inițiativa Vă ajutăm din Satu Mare aici: info.civicsuport.ro</li>
            <li>Vei fi contactat de un coordonator. El &icirc;ți va comunica dacă ești admis &icirc;n cadrul echipei Vă ajutăm din Satu Mare și care sunt următorii pași, adică cei de mai jos, dar cu date la care să te aștepți.</li>
            <li>Dacă ești admis &icirc;n cadrul echipei de voluntari altruiști, coordonatorul &icirc;ți va transmite data primului training.</li>
            <li>Vei participa la un training de platformă și de siguranță.</li>
            <li>Vei fi inclus &icirc;n grupul FB privat dedicat voluntarilor &icirc;nscriși și &icirc;n chaturile/grupurile Fb de voluntari pe echipe.</li>
            <li>Vei z&acirc;mbi și vei &icirc;ncepe să ajuți persoanele din categoria de risc &icirc;n caz de infecție &icirc;n aceste vremuri grele. Ne vei da cu siguranță feedback despre ce putem &icirc;mbunătăți &icirc;n acest flow, nu-i așa?</li>
          </ul>

          <div class="buttons-wrapper">
            <router-link :to="'/dashboard'">
              <el-button type="info">Dashboard</el-button>
            </router-link>
          </div>
        </div>

        <el-dialog
          title="DECLARAȚIE PE PROPRIE RĂSPUNDERE"
          :visible.sync="centerDialogVisible"
          width="80%"
          center
        >
          <form
            class="columns column is-multiline is-12"
            data-vv-scope="acordIsu"
            @submit.prevent="validateAcord('acordIsu')"
          >
            <el-row>
              <el-col>
                <p style="text-align: center;">
                  <strong>ACORD DE PRELUCRARE A DATELOR CU CARACTER PERSONAL</strong>
                </p>
                <p style="text-align: center;">&nbsp;</p>
                <p>
                  Subsemnatul
                  <el-input
                    v-model="voluteerForm.name"
                    v-validate="'required'"
                    name="voluteerForm.name"
                    class="special-form-input-text"
                    placeholder="Numele complet"
                  />, identificat cu C.I. seria nr.
                  <el-input
                    v-model="voluteerForm.ci"
                    v-validate="'required'"
                    name="voluteerForm.ci"
                    class="special-form-input-text"
                    placeholder="Ex: CJ 000000"
                  />, CNP
                  <el-input
                    v-model="voluteerForm.cnp"
                    v-validate="'required'"
                    name="voluteerForm.cnp"
                    class="special-form-input-text"
                    placeholder="Ex: 1890909090900"
                  />, cu domiciliul in loc
                  <el-input
                    v-model="voluteerForm.loc_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.loc_domiciliu"
                    class="special-form-input-text"
                    placeholder="Ex: Satu Mare, SM"
                  />, str
                  <el-input
                    v-model="voluteerForm.str_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.str_domiciliu"
                    class="special-form-input-text"
                    placeholder="Ex: Fierului"
                  />nr.
                  <el-input
                    v-model="voluteerForm.nr_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.nr_domiciliu"
                    class="special-form-input-text-no-width"
                    style="width: 100px"
                    placeholder="Ex: 22/A"
                  />, ap.
                  <el-input
                    v-model="voluteerForm.ap_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.ap_domiciliu"
                    class="special-form-input-text-no-width"
                    style="width: 80px"
                    placeholder="Ex: 9"
                  />, nr. tel.
                  <el-input
                    v-model="voluteerForm.phone"
                    v-validate="'required'"
                    name="voluteerForm.phone"
                    class="special-form-input-text"
                    placeholder="Ex: 075890375"
                  />, email
                  <el-input
                    v-model="voluteerForm.email"
                    v-validate="'required|email'"
                    class="special-form-input-text-no-width"
                    style="width: 250px"
                    name="voluteerForm.email"
                    placeholder="Ex: ioan.pop@example.com"
                  />,
                  <strong>declar că particip &icirc;n mod voluntar la activitățile de sprijinire a persoanelor care se află &icirc;n monitorizarea autorităților locale și a cadrelor medicale, &icirc;n contextul aplicării de către autorități a măsurilor de prevenire a infectării populației cu noul coronavirus(COVID-19</strong>
                  <strong>)</strong>.
                </p>
                <p>Declar prin prezenta că sunt conștient de natura activității care urmează să o desfășor și &icirc;mi asum eventualele consecințe &icirc;n cazul &icirc;n care voi suferi un accident sau voi fi vătămat, din cauze av&acirc;nd &icirc;n mod direct sau indirect legătură cu natura activității.&nbsp;</p>
                <p>Mă angajez să respect regulile de lucru pe care cadrele medicale si autoritațile le stabilesc și regulile de siguranță comunicate de către acestea.</p>
                <p>Autorizez și &icirc;mi dau consimțăm&acirc;ntul expres de a fi transportat la spital și de a mi se asigura asistența medicală &icirc;n cazul &icirc;n care acestea sunt necesare.</p>
                <p>Acord dreptul de a fi &icirc;nregistrat foto, audio și video pe perioada desfășurării activitaților și nu voi avea ulterior nici o pretenție materială sau de altă natură. Cunosc&acirc;nd că falsul &icirc;n declarații este pedepsit de legea penală, declar pe propria răspundere următoarele: sunt apt pentru participarea la aceste activitați de sprijin a persoanelor afectate de noul coronavirus; nu sufăr de afecţiuni grave sau contagioase care ar putea infuenţa activitatea desfașurată; voi urma toate instrucțiunile medicale si organizatorice comunicate de autorități.</p>
                <p>
                  Declar pe propria răspundere că am luat cunoștința de prevederile legale referitoare la protecția datelor cu caracter personal si
                  <strong>consimt să păstrez confidențialitatea datelor cu caracter personal</strong>a căror prelucrare o efectuez și a oricăror informații și date de care iau cunoștinta prin natura activității desfășurate, inclusiv după incetarea activității. Cunosc faptul ca &icirc;ncălcarea normelor legale privind protecția datelor pe care mi-am asumat-o prin prezenta, atrage răspunderea civilă si penală.&nbsp;
                </p>
                <p>
                  <strong>Declar că am fost informat cu privire la procesarea datelor cu caracter personal de către autoritați şi prin semnarea acestei declarații imi exprim consimţăm&acirc;ntul &icirc;n vederea prelucrării acestora, in scopurile pe care autoritățile le consideră necesare &icirc;n vederea desfășurării activitații pentru care m-am oferit voluntar.&nbsp;</strong>
                </p>
                <p>AM SEMNAT PREZENTUL DOCUMENT DUPĂ CE L-AM CITIT CU ATENȚIE ȘI AM &Icirc;NȚELES PE DEPLIN IMPLICAȚIILE REZULTATE DIN SEMNAREA LUI.</p>
                <p>
                  <strong>Denumirea organizatiei din care face parte voluntarul:</strong>
                </p>
                <p>Inițiativa Civică &ldquo;Vă ajutăm din Cluj&rdquo;, fondată pe baza protocolului de colaborare &icirc;ntre organizațiile Asociația Voci pentru Democrație și Justiție (VeDem Just), Asociația Civic Support, Asociația Clujul Sustenabil.</p>
                <p>Data:</p>
                <p>
                  <strong>{{ new Date().toLocaleDateString() }}</strong>
                </p>
                <p>Nume și prenume</p>
                <p>
                  <strong>{{ voluteerForm.name }}</strong>
                </p>
              </el-col>
            </el-row>
          </form>

          <span slot="footer" class="dialog-footer">
            <el-button
              style="margin-top: 8px"
              type="primary"
              @click="validateAcord('acordIsu')"
            >Sunt de acord si semnez</el-button>
            <el-button style="margin-top: 8px" @click="centerDialogVisible = false">Cancel</el-button>
          </span>
        </el-dialog>

        <el-dialog
          title="DECLARAȚIE DE VOLUNTARIAT"
          :visible.sync="centerDialogVisibleVoluntariat"
          width="80%"
          center
        >
          <form
            class="columns column is-multiline is-12"
            data-vv-scope="acordVoluntariat"
            @submit.prevent="validateAcord('acordVoluntariat')"
          >
            <el-row>
              <el-col>
                <p style="text-align: center;">
                  în acțiunile mișcării civice
                  <strong>„Vă ajutăm din Satu Mare”</strong> de susținere și ajutorare a locuitorilor din mun. Satu-Mare pentru a face față răspândirii și infectării cu virusul Covid-19
                </p>
                <p style="text-align: center;">&nbsp;</p>
                <p>
                  Subsemnatul
                  <el-input
                    v-model="voluteerForm.name"
                    v-validate="'required'"
                    name="voluteerForm.name"
                    class="special-form-input-text"
                    placeholder="Numele complet"
                  />, identificat cu C.I. seria nr.
                  <el-input
                    v-model="voluteerForm.ci"
                    v-validate="'required'"
                    name="voluteerForm.ci"
                    class="special-form-input-text"
                    placeholder="Ex: CJ 000000"
                  />, CNP
                  <el-input
                    v-model="voluteerForm.cnp"
                    v-validate="'required'"
                    name="voluteerForm.cnp"
                    class="special-form-input-text"
                    placeholder="Ex: 1890909090900"
                  />, cu domiciliul in loc
                  <el-input
                    v-model="voluteerForm.loc_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.loc_domiciliu"
                    class="special-form-input-text"
                    placeholder="Ex: Satu-Mare, SM"
                  />, str
                  <el-input
                    v-model="voluteerForm.str_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.str_domiciliu"
                    class="special-form-input-text"
                    placeholder="Ex: Fierului"
                  />nr.
                  <el-input
                    v-model="voluteerForm.nr_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.nr_domiciliu"
                    class="special-form-input-text-no-width"
                    style="width: 100px"
                    placeholder="Ex: 22/A"
                  />, ap.
                  <el-input
                    v-model="voluteerForm.ap_domiciliu"
                    v-validate="'required'"
                    name="voluteerForm.ap_domiciliu"
                    class="special-form-input-text-no-width"
                    style="width: 80px"
                    placeholder="Ex: 9"
                  />, nr. tel.
                  <el-input
                    v-model="voluteerForm.phone"
                    v-validate="'required'"
                    name="voluteerForm.phone"
                    class="special-form-input-text"
                    placeholder="Ex: 075890375"
                  />, email
                  <el-input
                    v-model="voluteerForm.email"
                    v-validate="'required|email'"
                    class="special-form-input-text-no-width"
                    style="width: 250px"
                    name="voluteerForm.email"
                    placeholder="Ex: ioan.pop@example.com"
                  />.
                </p>
                <p>
                  <strong>declar pe proprie răspundere următoarele:</strong>
                </p>
                <ol>
                  <li>
                    am decis de bună-voie să mă implic &icirc;n mișcarea civică
                    <strong>&bdquo;Vă ajutăm din Cluj&rdquo;</strong>;
                  </li>
                  <li>sunt de acord să mă implic voluntar &icirc;n aceste activități, fără a pretinde vreo remunerare sau recompensare;</li>
                  <li>accept că scopul implicării mele este unul eminamente civic. Ca urmare, nu voi urmări niciun scop politic sau economic;</li>
                  <li>mă oblig să mă informez &icirc;n mod constant cu privire la activitățile mișcării civice de pe grupul de facebook special creat;</li>
                  <li>mă oblig să &icirc;ndeplinesc atribuțiile pe care mi le asum și, &icirc;n caz de imposibilitate, să &icirc;nștiințez imediat inițiatorii acestei mișcări;</li>
                  <li>nu voi folosi &icirc;n interes privat informațiile conțin&acirc;nd date personale ale celor cu care intru &icirc;n contact și nu voi dezvălui publicului aceste informații;</li>
                  <li>sunt de acord ca datele mele de contact să fie folosite exclusiv pentru buna desfășurare a activităților din mișcarea civică menționată.</li>
                </ol>
                <p>Data:</p>
                <p>
                  <strong>{{ new Date().toLocaleDateString() }}</strong>
                </p>
                <p>Nume și prenume</p>
                <p>
                  <strong>{{ voluteerForm.name }}</strong>
                </p>
              </el-col>
            </el-row>
          </form>
          <span slot="footer" class="dialog-footer">
            <el-button
              style="margin-top: 8px"
              type="primary"
              @click="validateAcord('acordVoluntariat')"
            >Sunt de acord si semnez</el-button>
            <el-button
              style="margin-top: 8px"
              @click="centerDialogVisibleVoluntariat = false"
            >Cancel</el-button>
          </span>
        </el-dialog>
      </el-col>
    </el-row>
  </el-card>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

import Resource from '@/api/resource';

const volunteersResource = new Resource('volunteers');
export default {
  name: 'NewRegisterForm',

  data() {
    return {
      loading: false,
      active: 0,
      centerDialogVisible: false,
      centerDialogVisibleVoluntariat: false,
      judete: [],
      orase: [],
      voluteerForm: {
        acord: {
          acordIsu: false,
          acordVoluntariat: false,
        },
        acord_termeni: '',
        name: '',
        email: '',
        phone: '',
        age_range: '',
        county: 'SM',
        city: '',
        address: '',
        address_no: '',
        address_bl: '',
        address_sc: '',
        address_ap: '',
        involvement_direction: '',
        transportation_options: '',
        //car_plates: 'none',
        screening_questions: {
          situatie_locuire: [],
          parere_familie: '',
          transport_scopes: '',
          //dispatcher_question_1: 'none',
          dispatcher_question_2: '',
          dispatcher_question_3: '',
          //dispatcher_question_4: 'none',
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
          //volunteer_opinion: 'none',
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

  computed: {
    ...mapGetters(['roles', 'name', 'email', 'avatar', 'volunteer']),
  },

  mounted() {
    axios.get('https://roloca.coldfuse.io/judete').then(resp => {
      this.judete = resp.data;
    });

    this.getOraseJudet();

    this.voluteerForm = { ...this.voluteerForm, ...this.volunteer };

    if (!this.voluteerForm.screening_questions) {
      this.voluteerForm.screening_questions = {
        situatie_locuire: [],
        parere_familie: '',
        transport_scopes: '',
        //dispatcher_question_1: 'none',
        dispatcher_question_2: '',
        dispatcher_question_3: '',
        //dispatcher_question_4: 'none',
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
        //volunteer_opinion: 'none',
        volunteer_symptoms: '',
        volunteer_symptoms_details: [],
        other_volunteers_affections: '',
        other_volunteer_details: '',
        volunteer_nice_thoughts: '',
      };
    }

    if (this.volunteer) {
      this.voluteerForm.acord.acordIsu = !!this.volunteer.ip_acord;
      this.voluteerForm.acord.acordVoluntariat = !!this.volunteer
        .ip_acord_voluntariat;
      this.voluteerForm.acord_termeni = !!this.volunteer.acord_termeni;
    } else {
      this.voluteerForm.name = this.name;
      this.voluteerForm.email = this.email;
    }
  },

  methods: {
    registerVolunteer() {
      volunteersResource
        .store(this.voluteerForm)
        .then(response => {
          this.$message({
            message: 'Ai fost inregistrat ca voluntar',
            type: 'success',
            duration: 5 * 1000,
          });

          this.loading = false;
          this.active++;
          this.$store.dispatch('user/addVolunteer', response.volunteer);
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    update() {
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
          this.active++;
          this.$store.dispatch('user/addVolunteer', response.volunteer);
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    next(validate = false) {
      if (!validate) {
        if (this.active++ > 12) {
          this.active = 0;
        }
      } else {
        if (validate !== 'declaratiiForm') {
          this.$refs[validate].validate(valid => {
            if (valid) {
              this.active++;

              if (
                validate === 'endForm' &&
                !this.voluteerForm.acord.acordVoluntariat
              ) {
                this.centerDialogVisibleVoluntariat = true;
              }
            } else {
              console.log('error submit!!');
              return false;
            }
          });
        } else {
          if (
            this.voluteerForm.acord.acordVoluntariat &&
            this.voluteerForm.acord.acordIsu
          ) {
            if (this.voluteerForm.id) {
              this.update();
            } else {
              this.registerVolunteer();
            }
          } else {
            this.$message({
              message: 'Trebuie sa completezi toate formularele de acord',
              type: 'error',
              duration: 5 * 1000,
            });
          }
        }
      }
    },

    back() {
      if (this.active-- === 0) {
        this.active = 0;
      }
    },

    getOraseJudet() {
      axios
        .get('https://roloca.coldfuse.io/orase/' + this.voluteerForm.county)
        .then(resp => {
          this.orase = resp.data;
        });
    },

    validateAcord(scope) {
      console.log('validate click');

      this.$validator.validateAll(scope).then(res => {
        if (res) {
          this.voluteerForm.acord[scope] = true;
          if (this.centerDialogVisibleVoluntariat) {
            this.centerDialogVisibleVoluntariat = false;
            if (!this.voluteerForm.acord.acordIsu) {
              this.centerDialogVisible = true;
            }
          }

          if (this.centerDialogVisible) {
            this.centerDialogVisible = false;
          }
        } else {
          this.voluteerForm.acord[scope] = false;
          this.$message({
            message: 'Trebuie sa completezi toate datele acordului',
            type: 'error',
            duration: 5 * 1000,
          });
        }
      });
    },

    cancel() {
      this.$router.push('/dashboard');
    },
  },
};
</script>

<style lang="scss" >
.form-wrapper {
  margin: 15px;
  padding: 10px;

  .el-card__header {
    padding: 0px 10px;
  }

  .buttons-wrapper {
    width: 100%;
    text-align: center;
    margin-top: 25px;
  }

  .container-form {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 15px;
    background: #fbfbfb;

    max-width: 650px;
    margin: 20px auto;
  }

  .el-select {
    width: 100% !important;
  }

  .el-form-item {
    label {
      padding: 0 !important;
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
    clear: both !important;
  }
  .el-form-item__label {
    text-align: left;
  }

  .el-form-item--medium .el-form-item__content {
    clear: both !important;
  }

  .el-steps--horizontal {
    max-width: 660px;
    margin: 0 auto;
  }

  .checkbox-list {
    label {
      text-align: left !important;
      float: none !important;
      display: block !important;
    }
  }

  .el-form-item--medium .el-form-item__label {
    float: none !important;
    text-align: left !important;
    line-height: 25px;
  }

  .el-radio {
    line-height: 25px !important;
  }

  .left-radio-button {
    label {
      display: inline-block !important;
    }
  }
  .el-button {
    margin-top: 10px;
  }
}
</style>
