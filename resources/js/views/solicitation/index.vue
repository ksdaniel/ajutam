<template>
  <div class="login-container">
    <el-form ref="ruleForm" :model="ruleForm" :rules="rules" class="login-form" auto-complete="on" label-position="top" label-width="120px">
      <h3 class="title">
        Formular Solicitare
      </h3>
      <el-card>
        <p>&Icirc;n vremuri de criză e nevoie de implicare și solidaritate! Odată cu trecerea țării la scenariul 3 al crizei Corona Virus, s-a format &icirc;n mun. Satu Mare grupul de solidaritate comunitară &ldquo;VĂ AJUTĂM DIN SATU MARE!&rdquo;. Grupul are &icirc;n prezent 450 de membri și reunește mai mulți cetățeni activi, sub coordonarea a trei organizații implicate civic din Cluj: Vedem Just, Civic Suport și Clujul Sustenabil. Astfel, Clujul se alătură orașelor București, Sibiu, Arad și Constanța care au pornit inițiative similare pentru a sprijini cetățenii și autoritățile &icirc;n gestionarea situației generate de Corona Virus.</p>

        <el-form-item label="Nume" prop="name">
          <el-input v-model="ruleForm.name" />

          <el-form-item label="Nume" prop="first_name">
            <el-input v-model="ruleForm.first_name" />

          </el-form-item>

          <el-form-item label="Prenume" prop="last_name">
            <el-input v-model="ruleForm.last_name" />
          </el-form-item>

          <el-form-item label="Numar de telefon" prop="phone">
            <el-input v-model="ruleForm.phone" />
          </el-form-item>

          <el-form-item label="Strada" prop="address">
            <el-input v-model="ruleForm.address" />
          </el-form-item>

          <el-form-item label="Cartier" prop="neighborhood">
            <el-input v-model="ruleForm.neighborhood" />
          </el-form-item>

          <el-form-item label="Oras" prop="city">
            <el-input v-model="ruleForm.city" />
          </el-form-item>

          <el-form-item label="Judet" prop="county">
            <el-input v-model="ruleForm.county" />
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_10.label" prop="question_10">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_10.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_1.label" prop="question_1">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_1.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_2.label" prop="question_2">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_2.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_3.label" prop="question_3">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_3.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_4.label" prop="question_4">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_4.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_5.label" prop="question_5">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_5.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_6.label" prop="question_6">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_6.answer" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_7.label" prop="question_7">
            <el-col :span="24">

              <el-radio-group v-model="ruleForm.additional_responses.question_7.answer">
                <el-radio label="Am nevoie ca livrarea să fie făcută în cursul zilei de azi" style="margin-bottom: 10px">Am nevoie ca livrarea să fie făcută în cursul zilei de azi</el-radio>
                <el-radio label="Livrarea poate fi făcută în următoarele două, trei zile" style="margin-bottom: 10px">Livrarea poate fi făcută în următoarele două, trei zile</el-radio>
                <el-radio label="Livrarea poate fi făcută în cursul acestei săptămâni">Livrarea poate fi făcută în cursul acestei săptămâni</el-radio>
              </el-radio-group>
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_8.label" prop="question_8">
            <el-col :span="24">

              <el-radio-group v-model="ruleForm.additional_responses.question_8.answer">
                <el-radio label="Cash" style="margin-bottom: 10px">Cash</el-radio>
                <el-radio label="Card">Card</el-radio>
              </el-radio-group>
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_11.label" prop="question_11">
            <el-col :span="24">

              <el-input v-model="ruleForm.additional_responses.question_11.answer" type="textarea" :autosize="{ minRows: 4, maxRows: 6}" />
            </el-col>
          </el-form-item>

          <el-form-item :label="ruleForm.additional_responses.question_9.label" prop="question_9">
            <el-col :span="24">

              <el-radio-group v-model="ruleForm.additional_responses.question_9.answer">
                <el-radio label="Da" style="margin-bottom: 10px">Da</el-radio>
              </el-radio-group>
            </el-col>
          </el-form-item>

          <div class="links">
            <el-button type="success" :loading="loading" class="loginBtn" @click="createSolicitation()">Trimite Solicitarea</el-button>
          </div>
        </el-form-item></el-card>

    </el-form>

  </div>
</template>

<script>
import LangSelect from '@/components/LangSelect';
import { validEmail } from '@/utils/validate';
import Resource from '@/api/resource';
const solicitationsResource = new Resource('solicitations');

export default {
  name: 'Solicitation',
  components: { LangSelect },
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    const validatePass = (rule, value, callback) => {
      if (this.ruleForm.additional_responses.question_1.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }

      if (this.ruleForm.additional_responses.question_2.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_3.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_4.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_5.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_6.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_7.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_8.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
      if (this.ruleForm.additional_responses.question_9.answer === '') {
        callback(new Error('Camp obligatoriu'));
      } else {
        callback();
      }
    };
    return {

      rules: {

        name: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],

        first_name: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],

        last_name: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        phone: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        city: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        address: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        neighborhood: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        county: [{ required: true, message: 'Camp obligatoriu', trigger: 'blur' }],
        question_1: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_2: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_3: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_4: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_5: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_6: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_7: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_8: [{ required: true, validator: validatePass, trigger: 'blur' }],
        question_9: [{ required: true, validator: validatePass, trigger: 'blur' }],
      },
      loading: false,
      pwdType: 'password',
      redirect: undefined,
      ruleForm: {

        name: '',

        first_name: '',

        last_name: '',
        phone: '',
        city: '',
        address: '',
        neighborhood: '',
        county: '',
        categories: '',
        emergency: '',
        status: '',
        additional_responses: {
          question_1: {
            label: 'Care este motivul pentru care sunteți izolat la domiciliu?', answer: '',
          },
          question_2: {
            label: 'Prezentați simptome asociate Covid-19? Dacă da, care?', answer: '',
          },
          question_3: {
            label: 'Ați intrat în contact, din ce știți dvs, cu o persoană diagnosticată cu Covid-19?', answer: '',
          },
          question_4: {
            label: 'Ați călătorit/veniți dintr-o zonă afectată de virus? Dacă da, în ce dată?', answer: '',
          },
          question_5: {
            label: 'Ce vârstă aveți?', answer: '',
          },
          question_6: {
            label: 'Care sunt alimentele sau medicamentele de care aveți nevoie? (lista de cumpărături trebuie să fie în cantităţi rezonabile şi să se axeze pe strictul necesar, pe cât posibil fără baxuri de apă, întrucât apa de la robinet din Cluj-Napoca este potabilă)', answer: '',
          },
          question_7: {
            label: 'Cât de urgentă e solicitarea?', answer: '',
          },
          question_8: {
            label: 'Cum preferați să achitați cumpărăturile?', answer: '',
          },
          question_9: {
            label: 'Declar, pe proprie răspundere, că datele furnizate mai sus sunt reale.', answer: 'Da',
          },
          question_10: {
            label: 'În cazul în care locuiți la bloc care este scara și numărul apartamentului?', answer: '',
          },
          question_11: {
            label: 'Alte observații:', answer: '',
          },
        },
        observations: '',
        finish_date: '',
        volunteer_id: '',

      },
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect;
      },
      immediate: true,
    },
  },
  methods: {
    createSolicitation() {
      this.loading = true;

      this.$refs['ruleForm'].validate((valid) => {
        if (valid) {
          solicitationsResource
            .store(this.ruleForm)
            .then(response => {
              this.loading = false;

              this.$router.push({ path: '/succes' });
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

  },
};
</script>

<style rel="stylesheet/scss" lang="scss">
    $bg:#2d3a4b;
    $light_gray:#eee;

    /* reset element-ui css */

</style>

<style rel="stylesheet/scss" lang="scss" >
    /*body{*/
        /*background: #2d3a4b;*/
    /*}*/

    /*.app-main{*/
        /*background: white;*/
    /*}*/
</style>

<style rel="stylesheet/scss" lang="scss" scoped>
    $bg:#2d3a4b;
    $dark_gray:#889aa4;
    $light_gray:#eee;

    .login-container {

        height: 100%;
        width: 100%;
        background-color: $bg;
        .login-form {
            position: absolute;
            left: 0;
            right: 0;
            width: 750px;
            max-width: 100%;
            padding: 35px 35px 15px 35px;
            margin: 120px auto;
        }

        .title {
            font-size: 26px;
            font-weight: 400;
            color: $light_gray;
            margin: 0px auto 40px auto;
            text-align: center;
            font-weight: bold;
        }
        .show-pwd {
            position: absolute;
            right: 10px;
            top: 7px;
            font-size: 16px;
            color: $dark_gray;
            cursor: pointer;
            user-select: none;
        }
        .set-language {
            color: #fff;
            position: absolute;
            top: 40px;
            right: 35px;
        }

        /* Shared */
        .loginBtn {
            box-sizing: border-box;
            position: relative;
            /* width: 13em;  - apply for fixed size */
            margin: 0.2em;
            padding: 0 15px 0 46px;
            border: none;

            line-height: 34px;
            white-space: nowrap;
            border-radius: 0.2em;
            font-size: 16px;
            color: #FFF;
            width: 100%;
            text-align: center;
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

        /* Google */
        .loginBtn--google {
            /*font-family: "Roboto", Roboto, arial, sans-serif;*/
            background: #DD4B39;
        }
        .loginBtn--google:before {
            border-right: #BB3F30 1px solid;
            background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
        }
        .loginBtn--google:hover,
        .loginBtn--google:focus {
            background: #E74B37;
        }
    }
</style>
