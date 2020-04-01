<template>
  <el-form ref="volunteerFormName" :model="voluteerForm">
    <el-row>
      <el-col :xs="24" md="8" :sm="8" :lg="8"> <el-row :gutter="20">
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
      </el-row></el-col>
      <el-col :xs="24" md="8" :sm="8" :lg="8">

        <el-form-item prop="involvement_direction" label="Ce rol dorești să-ți asumi?" :rules="{ required: true, trigger: 'change', message: 'Campul trebuie completat' }">

          <el-radio-group v-model="voluteerForm.involvement_direction">
            <el-radio label="Call Center">Dispecer Call center - preia apeluri pe linia unică de dispecerat </el-radio>
            <el-radio label="Alimente">Livrator alimente</el-radio>
            <el-radio label="Medicamente">Livrator medicamente</el-radio>
          </el-radio-group>
        </el-form-item>

      </el-col>
      <el-col :xs="24" md="8" :sm="8" :lg="8" />

    </el-row>
  </el-form>
</template>

<script>
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
};
</script>

<style scoped>

</style>
